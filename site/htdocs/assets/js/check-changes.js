$(function(){
    
    change = document.getElementById('from');

    for (line=4; line<change_from.children.length; line++) {
        if (change_from.children[line].textContent != change_to.children[line].textContent) {
            change_to.children[line].style.color = 'red'
            change_to.children[line].style.fontWeight = '600'
        }
    }

}());