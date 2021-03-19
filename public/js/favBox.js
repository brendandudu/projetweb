function onClickBtnWish(event) {
    event.preventDefault();

    let url = this.href;
    let icon = this.querySelector('i');

    axios.get(url).then(function (response){
        if (icon.classList.contains('fas'))
            icon.classList.replace('fas', 'far');
        else
            icon.classList.replace('far', 'fas');
    }).catch(function (error) {
        if(error.response.status === 403)
            window.alert("Merci de vous connecter pour ajouter cet hébergement à votre liste d'envie")
    })
}

document.querySelectorAll('a.js-wish').forEach(function (link) {
    link.addEventListener('click', onClickBtnWish)
})