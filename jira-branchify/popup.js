document.getElementById("generate").addEventListener("click", async () => {
    let [tab] = await chrome.tabs.query({ active: true, currentWindow: true });

    chrome.scripting.executeScript({
        target: { tabId: tab.id },
        function: generateSlug
    }).then(injectionResults => {
        for (const { result } of injectionResults) {
            if (result) {
                copyToClipboard(result);
                document.getElementById("slug").textContent = result;
            }
        }
    });
});

function generateSlug() {
    let title = document.title || "pagina-sem-titulo";

    // Remover tudo após o último hífen
    title = title.replace(/\s*-\s*[^-]+$/, '');

    // Normalizar caracteres acentuados (remove diacríticos)
    title = title.normalize("NFD").replace(/[\u0300-\u036f]/g, "");

    // Criar slug
    let slug = title
        .trim()
        .toLowerCase()
        .replace(/[^\w\s-]/g, '')  // Remove caracteres especiais
        .replace(/\s+/g, '-')      // Substitui espaços por hífens
        .replace(/-+/g, '-');      // Remove múltiplos hífens

    // Limitar a 8 palavras
    let words = slug.split('-');
    if (words.length > 8) {
        slug = words.slice(0, 8).join('-');
    }

    return slug;
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).catch(err => console.error("Erro ao copiar: ", err));
}
