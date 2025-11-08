// Admin Dashboard JavaScript
document.addEventListener('DOMContentLoaded', function() {
    
    // Animar cards ao carregar
    animateCards();
    
    // Adicionar classe table-responsive às tabelas
    makeTablesResponsive();
    
    // Adicionar interatividade aos cards de estatísticas
    addStatsCardInteraction();
});

/**
 * Anima os cards ao carregar a página
 */
function animateCards() {
    const cards = document.querySelectorAll('.dashboard-card, .stats-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
}

/**
 * Adiciona classe table-responsive às tabelas
 */
function makeTablesResponsive() {
    const tableContainers = document.querySelectorAll('.overflow-x-auto');
    tableContainers.forEach(container => {
        container.classList.add('table-responsive');
    });
}

/**
 * Adiciona interatividade aos cards de estatísticas
 */
function addStatsCardInteraction() {
    const statsCards = document.querySelectorAll('.stats-card');
    
    statsCards.forEach(card => {
        // Efeito de pulso ao clicar
        card.addEventListener('click', function() {
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 100);
        });
    });
}

/**
 * Formata números grandes com abreviações (K, M)
 */
function formatNumber(num) {
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'M';
    }
    if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'K';
    }
    return num.toString();
}

/**
 * Atualiza valores dos cards com animação
 */
function updateCardValue(cardElement, newValue) {
    const valueElement = cardElement.querySelector('.text-3xl');
    if (!valueElement) return;
    
    const currentValue = parseInt(valueElement.textContent.replace(/\D/g, ''));
    const targetValue = newValue;
    const duration = 1000;
    const steps = 60;
    const increment = (targetValue - currentValue) / steps;
    let current = currentValue;
    let step = 0;
    
    const timer = setInterval(() => {
        step++;
        current += increment;
        valueElement.textContent = Math.round(current);
        
        if (step >= steps) {
            clearInterval(timer);
            valueElement.textContent = targetValue;
        }
    }, duration / steps);
}

/**
 * Detecta se está em mobile
 */
function isMobile() {
    return window.innerWidth <= 768;
}

/**
 * Ajusta layout baseado no tamanho da tela
 */
function adjustLayout() {
    if (isMobile()) {
        // Adiciona classes específicas para mobile
        document.body.classList.add('mobile-view');
    } else {
        document.body.classList.remove('mobile-view');
    }
}

// Ajusta layout ao redimensionar
window.addEventListener('resize', adjustLayout);
adjustLayout();
