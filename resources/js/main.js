const btnNuevoRegistro = document.querySelector('#btn-nuevo');

btnNuevoRegistro.addEventListener('click', () => {
    $('.bg-dark').css('display', 'table');
    $('.bg-dark').css('position', 'absolute');
})
/* 
$(function () {
    $(document).on('click', '#btn-nuevo', function () {
        $('#bg-dark').css('display', 'table');
        $('#bg-dark').css('position', 'absolute');
        alert('meow')
    });
}); */