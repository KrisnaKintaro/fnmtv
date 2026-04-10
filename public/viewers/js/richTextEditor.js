/* ==========================================
   TUGAS: Mengelola fitur Text Editor (Bold, Italic, Link, dll)
   ========================================== */

const RTE = {
    // 1. Inisialisasi otomatis untuk semua editor di halaman
    init: function (selector = ".rte-body") {
        const editors = document.querySelectorAll(selector);

        editors.forEach((editor) => {
            // Pasang event listener buat update status tombol toolbar
            editor.addEventListener("keyup", () =>
                this.updateToolbarState(editor),
            );
            editor.addEventListener("mouseup", () =>
                this.updateToolbarState(editor),
            );
            editor.addEventListener("click", () =>
                this.updateToolbarState(editor),
            );

            // Pasang fitur Clean Paste (Hanya teks polos)
            editor.addEventListener("paste", (e) => {
                e.preventDefault();
                const text = (e.originalEvent || e).clipboardData.getData(
                    "text/plain",
                );
                document.execCommand("insertText", false, text);
            });
        });
    },

    // 2. Eksekusi Perintah (Bold, Italic, dll)
    exec: function (command, value = null, editorId = null) {
        document.execCommand(command, false, value);

        // Fokus balik ke editor biar kursor ga ilang
        if (editorId) {
            document.getElementById(editorId).focus();
        }

        // Update visual tombol toolbar
        this.updateToolbarState();
    },

    // 3. Fitur Tambah Link
    insertLink: function () {
        const url = prompt("Masukkan URL link:", "https://");
        if (url && url !== "https://") {
            this.exec("createLink", url);
        }
    },

    // 4. Update Visual Tombol (Aktif/Tidak)
    updateToolbarState: function () {
        // 1. Cek Formatting Dasar (Bold, Italic, Underline)
        const basicCommands = {
            bold: ".rte-btn-bold",
            italic: ".rte-btn-italic",
            underline: ".rte-btn-underline",
        };

        Object.keys(basicCommands).forEach((cmd) => {
            const btn = document.querySelector(basicCommands[cmd]);
            if (btn) {
                document.queryCommandState(cmd)
                    ? btn.classList.add("active")
                    : btn.classList.remove("active");
            }
        });

        // 2. Cek Heading (H1, H2, H3)
        // formatBlock akan mengembalikan nama tag yang sedang aktif, misal "h1" atau "h2"
        const currentBlock = document.queryCommandValue("formatBlock");
        const headings = ["h1", "h2", "h3"];

        headings.forEach((h) => {
            const btn = document.querySelector(`.rte-btn-${h}`);
            if (btn) {
                currentBlock === h
                    ? btn.classList.add("active")
                    : btn.classList.remove("active");
            }
        });
    },
};

// Auto-init saat dokumen siap
$(document).ready(() => RTE.init());
