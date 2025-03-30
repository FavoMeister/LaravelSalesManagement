$(".selectRole").change(function(){
    var role = $(this).val();

    if (role != 'Administrator') {
        $(".selectBranch").show();
    } else {
        $(".selectBranch").hide();
    }
});