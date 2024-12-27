$(document).ready(function () {
    var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn'),allPrevBtn = $('.prevBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
                $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-info').addClass('btn-default');
            $item.addClass('btn-info');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    $(".setup-content").hide();
    $(".setup-content:first").show();

    allNextBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='number'],select,textarea"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        $(".help-block").remove();

        for(var i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
                $(curInputs[i]).after('<span class="help-block" style="color: red;">Please enter a valid value</span>');
            }
        }

        if (isValid) {
            curStep.animate({
                opacity: 0,
                marginLeft: "-100%"
            }, 400, function () {
                curStep.hide();
                nextStepWizard.removeAttr('disabled').trigger('click');
                nextStepWizard.addClass('btn-info').removeClass('btn-default');
                curStep.removeClass('active').next().addClass('active').css("opacity", 0).show().animate({
                    opacity: 1,
                    marginLeft: 0
                }, 400);
            });
        }

        setTimeout(function() {
            $(".form-group").removeClass("has-error");
            $(".help-block").remove();
        }, 5000);
    });

    allPrevBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

        curStep.animate({
            opacity: 0,
            marginLeft: "100%"
        }, 400, function () {
            curStep.hide();
            prevStepWizard.trigger('click');
            prevStepWizard.addClass('btn-info').removeClass('btn-default');
            curStep.removeClass('active').prev().addClass('active').css("opacity", 0).show().animate({
                opacity: 1,
                marginLeft: 0
            }, 400);
        });
    });

    $('div.setup-panel div a.btn-info').trigger('click');
});