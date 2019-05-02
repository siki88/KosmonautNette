$(function(){

});

/*

jush.create_links = false;
jush.highlight_tag('code');
$('code.jush').each(function(){ $(this).html($(this).html().replace(/\x7B[/$\w].*?\}/g, '<span class="jush-latte">$&</span>')) });

$('a[href^="#"]').click(function(){
    $('html,body').animate({ scrollTop: $($(this).attr('href')).show().offset().top - 5 }, 'fast');
    return false;
});

*/

UIkit.util.on('#js-modal-prompt', 'click', function (e) {
    e.preventDefault();
    e.target.blur();
    UIkit.modal.prompt('Name:', 'Your name').then(function (name) {
        console.log('Prompted:', name)
    });
});

UIkit.util.on('#js-modal-alert', 'click', function (e) {
    e.preventDefault();
    e.target.blur();
    UIkit.modal.alert('Chcete opravdu smazat').then(function () {
        console.log('Alert closed.')
    });
});


$('.alert').show(0).delay(5000).hide(0);

