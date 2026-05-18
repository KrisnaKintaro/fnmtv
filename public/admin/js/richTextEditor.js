/* ==========================================
   TUGAS: Mengelola fitur Text Editor (Bold, Italic, Link, dll)
   ========================================== */

const RTE = {
    init: function (selector = ".rte-body") {
        const editors = document.querySelectorAll(selector);

        editors.forEach((editor) => {
            editor.addEventListener("keyup", () => this.updateToolbarState());
            editor.addEventListener("mouseup", () => this.updateToolbarState());
            editor.addEventListener("click", () => this.updateToolbarState());

            // Clean Paste
            editor.addEventListener("paste", (e) => {
                e.preventDefault();
                const text = (e.originalEvent || e).clipboardData.getData("text/plain");
                document.execCommand("insertText", false, text);
            });
        });
    },

    exec: function (command, value = null) {
        document.execCommand(command, false, value);
        this.updateToolbarState();
    },

    // FITUR BARU: APPLY HEADING & NORMAL (Tanpa sistem toggle yang bikin ribet)
    applyHeading: function (tag) {
        const selection = window.getSelection();
        if (!selection.rangeCount) return;

        const text = selection.toString();

        if (tag === 'normal') {
            // TOMBOL NORMAL: Hapus semua styling (inline span) & balikin ke Paragraf
            document.execCommand("removeFormat", false, null);
            try { document.execCommand("formatBlock", false, "P"); }
            catch (e) { document.execCommand("formatBlock", false, "<p>"); }
        } else {
            // TOMBOL H1, H2, H3
            if (text.length > 0) {
                const node = selection.anchorNode;
                let parentBlock = node;
                while (parentBlock && parentBlock.nodeType !== 1) {
                    parentBlock = parentBlock.parentNode;
                }
                const parentText = parentBlock ? parentBlock.textContent : "";

                if (text.trim() === parentText.trim()) {
                    // Full 1 baris
                    try { document.execCommand("formatBlock", false, tag); }
                    catch (e) { document.execCommand("formatBlock", false, `<${tag}>`); }
                } else {
                    // Sebagian teks (Inline) -> Hapus format lama, timpa yg baru (Misal H3 diganti ke H1)
                    document.execCommand("removeFormat", false, null);
                    let size = tag.toLowerCase() === 'h1' ? '28px' : (tag.toLowerCase() === 'h2' ? '24px' : '20px');
                    const html = `<span style="font-size: ${size}; font-weight: bold;">${text}</span>`;
                    document.execCommand("insertHTML", false, html);
                }
            } else {
                // Kursor diam (Tidak blok teks)
                try { document.execCommand("formatBlock", false, tag); }
                catch (e) { document.execCommand("formatBlock", false, `<${tag}>`); }
            }
        }
        this.updateToolbarState();
    },

    insertLink: function () {
        const url = prompt("Masukkan URL link:", "https://");
        if (url && url !== "https://") {
            this.exec("createLink", url);
        }
    },

    updateToolbarState: function () {
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

        const currentBlock = document.queryCommandValue("formatBlock") || "";
        const headings = ["h1", "h2", "h3", "p"];

        headings.forEach((h) => {
            // Cek kalau tag-nya P, berarti tombol Normal yang aktif
            const btn = document.querySelector(h === 'p' ? '.rte-btn-normal' : `.rte-btn-${h}`);
            if (btn) {
                (currentBlock.toLowerCase() === h)
                    ? btn.classList.add("active")
                    : btn.classList.remove("active");
            }
        });
    },
};

document.addEventListener("DOMContentLoaded", function() {
    RTE.init();
});
