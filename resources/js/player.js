/* =======================
   GLOBAL STATE
======================= */
let index = 0;
let timer = null;
let stopped = false;
let started = false;

const VIDEO_EXT = ["mp4", "mov", "avi", "mkv", "webm"];
const IMAGE_EXT = ["jpg", "jpeg", "png", "gif", "webp"];

const player = document.getElementById("player");
const btnStop = document.getElementById("btnStop");

/* =======================
   PLAY NEXT ITEM
======================= */
function playNext() {
    if (stopped || !window.PLAYLIST || !window.PLAYLIST.length) return;

    clearTimeout(timer);
    timer = null;
    player.innerHTML = "";

    const item = window.PLAYLIST[index];
    if (!item || !item.file) {
        next();
        return;
    }

    const orientasi = (item.orientasi || "Landscape").toLowerCase();
    document.body.className = "mode-" + orientasi;

    const file = `/storage/${item.file}`;
    const ext = file.split("?")[0].split(".").pop().toLowerCase();

    /* ===== VIDEO ===== */
    if (VIDEO_EXT.includes(ext)) {
        const video = document.createElement("video");
        video.src = file;
        video.muted = false;
        video.playsInline = true;
        video.preload = "auto";
        video.onended = next;
        video.onerror = next;
        video.oncanplay = () => video.play().catch(() => {});
        player.appendChild(video);
        return;
    }

    /* ===== IMAGE ===== */
    if (IMAGE_EXT.includes(ext)) {
        const img = document.createElement("img");
        img.src = file;
        img.onload = () => {
            const dur = item.duration && item.duration > 0 ? item.duration : 10;
            timer = setTimeout(next, dur * 1000);
        };
        img.onerror = next;
        player.appendChild(img);
        return;
    }

    next();
}

/* =======================
   NEXT INDEX
======================= */
function next() {
    index++;
    if (index >= window.PLAYLIST.length) index = 0;
    playNext();
}

/* =======================
   STOP BUTTON
======================= */
if (btnStop) {
    btnStop.addEventListener("click", async () => {
        stopped = true;
        started = false;
        clearTimeout(timer);
        timer = null;
        player.innerHTML = "";

        if (document.fullscreenElement) {
            document.exitFullscreen().catch(() => {});
        }

        try {
            await fetch("/stop-playlist", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content"),
                },
            });
        } catch (e) {}

        window.location.href = "/admin";
    });
}

/* =======================
   START (USER GESTURE)
======================= */
document.addEventListener(
    "click",
    () => {
        if (!started) {
            started = true;
            playNext();
        }
        document.documentElement.requestFullscreen?.().catch(() => {});
    },
    { once: true },
);

const el = document.querySelector("video, img");

function adjust() {
    const w = el.videoWidth || el.naturalWidth;
    const h = el.videoHeight || el.naturalHeight;

    if (w > h) {
        // LANDSCAPE → BESARKAN dikit
        el.style.transform = "scale(1.4)";
    } else {
        // PORTRAIT normal
        el.style.transform = "scale(1)";
    }
}

if (el.tagName === "VIDEO") {
    el.onloadedmetadata = adjust;
} else {
    el.onload = adjust;
}
