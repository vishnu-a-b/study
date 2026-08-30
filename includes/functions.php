<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

/** Escape for HTML output. */
function h(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function asset(string $path): string
{
    return BASE_URL . 'assets/' . ltrim($path, '/');
}

/** Build initials (e.g. "P S Mahmood" -> "PM") for members with no photo. */
function initials(string $name): string
{
    $parts = preg_split('/\s+/', trim($name));
    $parts = array_values(array_filter($parts));
    if (count($parts) === 0) {
        return '?';
    }
    if (count($parts) === 1) {
        return mb_strtoupper(mb_substr($parts[0], 0, 2));
    }
    return mb_strtoupper(mb_substr($parts[0], 0, 1) . mb_substr(end($parts), 0, 1));
}

// ---------------- CSRF ----------------

function csrf_token(): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf(?string $token): bool
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

// ---------------- Data access ----------------

/** @return array<int, array<string, mixed>> */
function get_services(bool $homeOnly = false): array
{
    $pdo = get_pdo();
    $sql = 'SELECT * FROM services';
    if ($homeOnly) {
        $sql .= ' WHERE show_on_home = 1';
    }
    $sql .= ' ORDER BY sort_order ASC';
    return $pdo->query($sql)->fetchAll();
}

/** Echoes a \n\n-separated block of text as escaped <p> paragraphs. */
function render_paragraphs(?string $text): void
{
    $paragraphs = preg_split('/\n{2,}/', trim($text ?? ''));
    foreach ($paragraphs as $para) {
        if (trim($para) === '') {
            continue;
        }
        echo '<p>' . h($para) . "</p>\n";
    }
}

/** The next service after $slug in sort_order, wrapping around to the first. */
function get_next_service(string $slug): ?array
{
    $all = get_services();
    $count = count($all);
    foreach ($all as $i => $svc) {
        if ($svc['slug'] === $slug) {
            return $all[($i + 1) % $count];
        }
    }
    return null;
}

function get_service_by_slug(string $slug): ?array
{
    $stmt = get_pdo()->prepare('SELECT * FROM services WHERE slug = :slug LIMIT 1');
    $stmt->execute(['slug' => $slug]);
    $row = $stmt->fetch();
    return $row ?: null;
}

/** @return array<int, array<string, mixed>> */
function get_testimonials(?int $limit = null): array
{
    $sql = 'SELECT * FROM testimonials ORDER BY sort_order ASC';
    if ($limit !== null) {
        $sql .= ' LIMIT ' . (int) $limit;
    }
    return get_pdo()->query($sql)->fetchAll();
}

/** @return array<int, array<string, mixed>> */
function get_team_members(): array
{
    $sql = 'SELECT tm.*, b.name AS branch_name
            FROM team_members tm
            LEFT JOIN branches b ON b.id = tm.branch_id
            ORDER BY tm.sort_order ASC';
    return get_pdo()->query($sql)->fetchAll();
}

/** @return array<int, array<string, mixed>> */
function get_branches(): array
{
    return get_pdo()->query('SELECT * FROM branches ORDER BY sort_order ASC')->fetchAll();
}

/** @return array<int, array<string, mixed>> */
function get_stats(string $group): array
{
    $stmt = get_pdo()->prepare('SELECT * FROM stats WHERE group_key = :g ORDER BY sort_order ASC');
    $stmt->execute(['g' => $group]);
    return $stmt->fetchAll();
}

/** @return array<int, array<string, mixed>> */
function get_faqs(): array
{
    return get_pdo()->query('SELECT * FROM faqs ORDER BY sort_order ASC')->fetchAll();
}

/** @return array<int, array<string, mixed>> */
function get_partner_logos(): array
{
    return get_pdo()->query('SELECT * FROM partner_logos ORDER BY sort_order ASC')->fetchAll();
}

/**
 * Static content for the homepage "study destinations" globe section.
 * Not DB-backed (unlike partner_logos) because it needs richer per-country
 * copy/coordinates than that table has, and this content changes rarely.
 * Coordinates are approximate capital/major-city lat/lng, used to place
 * markers on the 3D globe and draw connection arcs from ORIGIN.
 *
 * @return array<int, array<string, mixed>>
 */
function get_study_destinations(): array
{
    return [
        [
            'slug' => 'uk', 'flag' => '🇬🇧', 'name' => 'United Kingdom',
            'lat' => 51.5074, 'lng' => -0.1278,
            'description' => 'Study in one of the world’s leading education destinations, home to centuries-old universities and globally recognised degrees.',
            'stats' => ['Globally ranked universities', 'Graduate Route post-study work visa', 'Rich, multicultural student life'],
        ],
        [
            'slug' => 'usa', 'flag' => '🇺🇸', 'name' => 'United States',
            'lat' => 38.9072, 'lng' => -77.0369,
            'description' => 'Access the widest range of courses and campuses on earth, from Ivy League research powerhouses to specialised STEM programs.',
            'stats' => ['World top-ranked universities', 'Optional Practical Training (OPT)', 'Extensive scholarship options'],
        ],
        [
            'slug' => 'canada', 'flag' => '🇨🇦', 'name' => 'Canada',
            'lat' => 45.4215, 'lng' => -75.6972,
            'description' => 'A welcoming, affordable path to a globally respected degree, with some of the clearest immigration pathways for graduates.',
            'stats' => ['Highly ranked, affordable education', 'Strong post-study work pathways', 'Welcoming immigration policies'],
        ],
        [
            'slug' => 'australia', 'flag' => '🇦🇺', 'name' => 'Australia',
            'lat' => -35.2809, 'lng' => 149.1300,
            'description' => 'World-class research universities paired with a relaxed, safe lifestyle across some of the world’s most liveable cities.',
            'stats' => ['World-class research universities', 'Post-study work visa options', 'Safe, student-friendly cities'],
        ],
        [
            'slug' => 'malta', 'flag' => '🇲🇹', 'name' => 'Malta',
            'lat' => 35.8989, 'lng' => 14.5146,
            'description' => 'English-taught EU degrees on a compact Mediterranean island — a safe, sunny gateway into the European Union.',
            'stats' => ['English-taught EU degrees', 'Compact, safe island campuses', 'Gateway to the European Union'],
        ],
        [
            'slug' => 'singapore', 'flag' => '🇸🇬', 'name' => 'Singapore',
            'lat' => 1.3521, 'lng' => 103.8198,
            'description' => 'A world-leading Asian education hub with tight industry connections and one of the safest, most modern cities anywhere.',
            'stats' => ['World-leading Asian universities', 'Strong industry connections', 'Safe, multicultural hub'],
        ],
        [
            'slug' => 'uae', 'flag' => '🇦🇪', 'name' => 'Dubai, UAE',
            'lat' => 25.2048, 'lng' => 55.2708,
            'description' => 'Study at respected international branch campuses in a tax-free, fast-growing global business hub close to home.',
            'stats' => ['International branch campuses', 'Tax-free work opportunities', 'Major global business hub'],
        ],
        [
            'slug' => 'malaysia', 'flag' => '🇲🇾', 'name' => 'Malaysia',
            'lat' => 3.1390, 'lng' => 101.6869,
            'description' => 'Affordable, quality degrees from British and Australian branch campuses, in a multicultural setting close to home.',
            'stats' => ['Affordable, quality education', 'British & Australian branch campuses', 'Multicultural, budget-friendly living'],
        ],
    ];
}

/** Simple inline-SVG icon set for services, keyed by services.icon_key. Kept in one place, no external icon font. */
function service_icon(string $key): string
{
    $icons = [
        'compass'        => '<circle cx="12" cy="12" r="9"/><path d="M14.5 9.5 12 12l-2.5 2.5L12 12l2.5-2.5Z"/>',
        'university'     => '<path d="M12 3 2 8l10 5 10-5-10-5Z"/><path d="M6 11v6c0 1 2.5 2 6 2s6-1 6-2v-6"/>',
        'passport'       => '<rect x="5" y="2" width="14" height="20" rx="2"/><circle cx="12" cy="10" r="3"/><path d="M9 17h6"/>',
        'book-open'      => '<path d="M12 6c-2-1.5-5-2-8-1v13c3-1 6-.5 8 1 2-1.5 5-2 8-1V5c-3-1-6-.5-8 1Z"/>',
        'plane-takeoff'  => '<path d="M3 19h18"/><path d="m5 14 6-2 7-6c1-.6 2 .5 1.3 1.4L14 14l-3 1-2-2-3 1Z"/>',
        'plane-landing'  => '<path d="M3 19h18"/><path d="M7 15 4 9c-.3-.9.6-1.7 1.4-1.2L11 11l3-6 1.8.6-1.6 6.4 3.8 1.5c.9.3.9 1.6 0 1.9L11 17Z" transform="translate(0,-1)"/>',
        'briefcase'      => '<rect x="3" y="8" width="18" height="12" rx="2"/><path d="M8 8V6a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>',
        'home'           => '<path d="m3 11 9-7 9 7"/><path d="M5 10v10h14V10"/>',
        'scholarship-cap'=> '<path d="M12 4 2 9l10 5 10-5-10-5Z"/><path d="M6 12v5c0 1.2 2.7 3 6 3s6-1.8 6-3v-5"/>',
        'default'        => '<circle cx="12" cy="12" r="9"/>',
    ];
    return $icons[$key] ?? $icons['default'];
}
