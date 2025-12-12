/* --- GERENCIAMENTO DE MODAIS --- */
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = "block";
    } else {
        console.error(`Erro: Modal com ID '${modalId}' não foi encontrado no HTML.`);
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.style.display = "none";
}

// Fecha o modal ao clicar na parte escura (fora da janela)
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = "none";
    }
}

/* --- FUNÇÕES DE AÇÃO --- */

// NOVO: Função específica para abrir o modal de cadastro e limpar o formulário
function newTCC() {
    // Busca o formulário dentro do modal para limpar os campos
    const form = document.querySelector('#modalNovoTCC form');
    if (form) {
        form.reset(); // Limpa inputs anteriores
    }
    
    openModal('modalNovoTCC');
}

// VISUALIZAR: Recebe o elemento botão (this) e lê os dados dele
function viewTCC(element) {
    if (!element) return;

    // Pega os dados dos atributos data-*
    const titulo = element.getAttribute('data-titulo');
    const aluno = element.getAttribute('data-aluno');
    const orientador = element.getAttribute('data-orientador');
    const status = element.getAttribute('data-status');
    const area = element.getAttribute('data-area');
    const resumo = element.getAttribute('data-resumo');

    // Preenche o Modal
    // Usa 'safeSet' para evitar erro se o elemento não existir
    safeSetText('viewTitulo', titulo);
    safeSetText('viewAluno', aluno);
    safeSetText('viewOrientador', orientador);
    safeSetText('viewArea', area);
    safeSetText('viewResumo', resumo);

    // Ajusta a cor do Status
    const statusBadge = document.getElementById('viewStatus');
    if (statusBadge && status) {
        statusBadge.innerText = status.charAt(0).toUpperCase() + status.slice(1);
        statusBadge.className = `status ${status.toLowerCase()}`;
    }

    openModal('modalVisualizar');
}

// EDITAR: Preenche o formulário de edição
function editTCC(element) {
    if (!element) return;

    const id = element.getAttribute('data-id');
    const titulo = element.getAttribute('data-titulo');
    const status = element.getAttribute('data-status');

    // Preenche os inputs do formulário de edição
    const inputId = document.getElementById('editId');
    const inputTitulo = document.getElementById('editTitulo');
    const inputStatus = document.getElementById('editStatus');

    if(inputId) inputId.value = id;
    if(inputTitulo) inputTitulo.value = titulo;
    if(inputStatus) inputStatus.value = status;

    openModal('modalEditar');
}

// EXCLUIR: Redireciona para o handler PHP
function confirmDelete(id) {
    if(confirm("Tem certeza que deseja excluir este projeto permanentemente?")) {
        // CORREÇÃO AQUI: Removemos o 'src/' do caminho
        // Caminho: Sai de View/Coordenador (../../) e entra em Controller
        window.location.href = `../../Controller/TccHandler.php?action=delete&id=${id}`;
    }
}

/* --- TABS DO RELATÓRIO --- */
function switchTab(tabId, btnElement) {
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(content => content.classList.remove('active'));

    const btns = document.querySelectorAll('.tab-btn');
    btns.forEach(btn => btn.classList.remove('active'));

    const target = document.getElementById(tabId);
    if(target) target.classList.add('active');
    
    if(btnElement) btnElement.classList.add('active');
}

// Função utilitária para evitar erros se o ID não existir no HTML
function safeSetText(id, text) {
    const el = document.getElementById(id);
    if (el) el.innerText = text || '-';
}

function newBanca() {
    const form = document.querySelector('#modalNovaBanca form');
    if (form) form.reset();
    openModal('modalNovaBanca');
}