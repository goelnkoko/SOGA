function showTab(tabId) {
    var tabs = document.getElementsByClassName('tab');
    var tabPanes = document.getElementsByClassName('tab-pane');

    for (var i = 0; i < tabs.length; i++) {
        tabs[i].classList.remove('active');
    }

    for (var i = 0; i < tabPanes.length; i++) {
        tabPanes[i].classList.remove('active');
    }

    document.querySelector('.tab[onclick="showTab(\'' + tabId + '\')"]').classList.add('active');
    document.getElementById(tabId).classList.add('active');
}
