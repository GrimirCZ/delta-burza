require('./bootstrap');

global.redirectToRegion = (option) => {
    window.location.href = "/vystavy/"+option.value
};

global.burgerMenu = false

global.toggleMenu = () => {
    global.burgerMenu = ! global.burgerMenu
    document.getElementById('burger-menu').style.width = global.burgerMenu ? "auto" : 0
}
