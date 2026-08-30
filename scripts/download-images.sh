#!/usr/bin/env bash
# Downloads the real images used on the live studwise.in site into public/assets/images/.
# Run from the project root: bash scripts/download-images.sh
set -uo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
IMG_DIR="$ROOT/public/assets/images"
BASE="https://studwise.in/wp-content/uploads"
UA="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) StudwiseRebuildBot/1.0"

mkdir -p "$IMG_DIR"/{hero,flags,office,team,partners}

fail=0

fetch() {
    local url="$1" dest="$2"
    if curl -fsSL -A "$UA" "$url" -o "$dest"; then
        local mime
        mime=$(file -b --mime-type "$dest")
        if [[ "$mime" != image/* ]]; then
            echo "WARN: $dest downloaded but is not an image (mime=$mime) — removing"
            rm -f "$dest"
            fail=1
        else
            echo "OK:   $dest  ($mime)"
        fi
    else
        echo "FAIL: $url"
        fail=1
    fi
}

# ---- logo ----
fetch "$BASE/2023/03/Studwise-TM-Logo-1-1024x546.png" "$IMG_DIR/logo.png"

# ---- hero / feature images ----
# (fetching the unsuffixed originals instead of WordPress's downscaled -WIDTHxHEIGHT thumbnails)
fetch "$BASE/2024/01/Best-Educational-Consultancy-in-Malappuram.webp"           "$IMG_DIR/hero/hero-main.webp"
fetch "$BASE/2025/05/Studwise-study-abroad-scaled.webp"                                 "$IMG_DIR/hero/hero-study-abroad.webp"
fetch "$BASE/2023/06/Study-Abroad-Consultants-in-Kerala.webp"                           "$IMG_DIR/hero/study-abroad-consultants.webp"
fetch "$BASE/2023/06/Best-Educational-Consultants-in-Kerala.webp"              "$IMG_DIR/hero/educational-consultants-kerala.webp"
fetch "$BASE/2023/06/Best-Educational-Consultants-in-Malappuram.webp"          "$IMG_DIR/hero/educational-consultants-malappuram.webp"
fetch "$BASE/2023/06/Best-Overseas-Education-Consultants-in-Kerala.webp"       "$IMG_DIR/hero/overseas-education-consultants-kerala.webp"
fetch "$BASE/2023/06/Best-Overseas-Education-Consultants-in-Malappuram.webp"   "$IMG_DIR/hero/overseas-education-consultants-malappuram.webp"

# ---- flags / world map ----
fetch "$BASE/2023/03/flag-details.png" "$IMG_DIR/flags/flag-details.png"
fetch "$BASE/2023/03/images-20.png"    "$IMG_DIR/flags/world-map.png"

# ---- office / students ----
fetch "$BASE/2025/05/Studwise-valanchery-office.webp" "$IMG_DIR/office/valanchery-office.webp"
fetch "$BASE/2025/05/Study-abroad-students.webp"      "$IMG_DIR/office/study-abroad-students.webp"
fetch "$BASE/2023/07/pre-landing-services.webp"                "$IMG_DIR/hero/pre-landing-services.webp"

# ---- candid gallery photos (unnamed WhatsApp exports used on the live site) ----
fetch "$BASE/2023/03/WhatsApp-Image-2023-03-29-at-10.16.21-AM-1.jpeg" "$IMG_DIR/office/gallery-1.jpeg"
fetch "$BASE/2023/03/WhatsApp-Image-2023-03-29-at-4.07.56-PM.jpeg"             "$IMG_DIR/office/gallery-2.jpeg"
fetch "$BASE/2023/04/WhatsApp-Image-2023-04-02-at-11.23.50-PM-2.jpeg"          "$IMG_DIR/office/gallery-3.jpeg"
fetch "$BASE/2023/04/WhatsApp-Image-2023-04-02-at-11.23.50-PM.jpeg"            "$IMG_DIR/office/gallery-4.jpeg"
fetch "$BASE/2023/04/WhatsApp-Image-2023-04-04-at-11.32.55-AM-e1680589214108.jpeg" "$IMG_DIR/office/gallery-5.jpeg"

# ---- team headshots (Testimonials page "Meet Our Most Trusted" grid) ----
fetch "$BASE/brizy/imgs/Mahroof-scaled-152x203x0x0x152x203x1705301274.webp"                 "$IMG_DIR/team/mahroof.webp"
fetch "$BASE/brizy/imgs/Ashwathy-scaled-152x203x0x0x152x203x1705301491.webp"                "$IMG_DIR/team/ashwathy.webp"
fetch "$BASE/brizy/imgs/Shana-scaled-152x203x0x0x152x203x1705301172.webp"                   "$IMG_DIR/team/shana.webp"
fetch "$BASE/brizy/imgs/Hashim-scaled-152x203x0x0x152x203x1705301541.webp"                  "$IMG_DIR/team/hashim.webp"
fetch "$BASE/brizy/imgs/Lubaba-scaled-82x110x0x0x82x110x1705302107.webp"                    "$IMG_DIR/team/lubaba.webp"
fetch "$BASE/brizy/imgs/Sandhra-82x146x0x18x82x111x1705301847.webp"                         "$IMG_DIR/team/sandhra.webp"
fetch "$BASE/brizy/imgs/Badriya-scaled-83x110x0x0x83x110x1705302263.webp"                   "$IMG_DIR/team/badriya.webp"
fetch "$BASE/brizy/imgs/Aparna-scaled-82x110x0x0x82x110x1705302428.webp"                    "$IMG_DIR/team/aparna.webp"
fetch "$BASE/brizy/imgs/jimsy-scaled-82x146x0x16x82x111x1705302618.webp"                    "$IMG_DIR/team/jimsy.webp"
fetch "$BASE/brizy/imgs/Adarsha-83x135x0x32x83x102x1705302699.webp"                         "$IMG_DIR/team/adarsha.webp"
fetch "$BASE/brizy/imgs/Faseela--scaled-123x164x17x16x84x88x1705302839.webp"                "$IMG_DIR/team/faseela.webp"

if [[ $fail -ne 0 ]]; then
    echo
    echo "One or more downloads failed or were rejected — see WARN/FAIL lines above."
    exit 1
fi

echo
echo "All images downloaded successfully into $IMG_DIR"
