require('./bootstrap');

global.redirectToRegion = (option) => {
    window.location.href = "/vystavy/"+option.value
};
