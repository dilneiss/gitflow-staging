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
    function generateSlugJira() {
        let title = document.title || "jira-sem-titulo";

        // Remove tudo após o último hífen
        title = title.replace(/\s*-\s*[^-]+$/, '');

        // Normaliza e sanitiza
        title = title.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        let slug = title
            .trim()
            .toLowerCase()
            .replace(/[^\w\s-]/g, '')  // Remove caracteres especiais
        .replace(/\s+/g, '-')      // Substitui espaços por hífens
        .replace(/-+/g, '-');      // Remove múltiplos hífens

        // Limita a 8 palavras
        let words = slug.split('-');
        if (words.length > 8) {
            slug = words.slice(0, 8).join('-');
        }

        return slug;
    }

    function generateSlugAgi() {
        const match = window.location.href.match(/\/atendimento\/(\d+)/);
        if (!match) return "atendimento-sem-id";

        const id = match[1];
        const titleElement = document.querySelector(`#task-title-${id}`);
        if (!titleElement) return `ATD-${id}`;

        let title = titleElement.textContent || "sem-titulo";

        // Normaliza e sanitizar
        title = title.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        let slug = title
            .trim()
            .toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');

        // Limita a 8 palavras
        let words = slug.split('-');
        if (words.length > 8) {
            slug = words.slice(0, 8).join('-');
        }

        return `ATD-${id}-${slug}`;
    }

    const url = window.location.href;

    if (url.includes("atlassian.net/browse/")) {
        return generateSlugJira();
    }

    if (url.includes("agidesk.com/br/painel/atendimento/")) {
        return generateSlugAgi();
    }

    return "Site Incorreto";
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).catch(err => console.error("Erro ao copiar: ", err));
}
