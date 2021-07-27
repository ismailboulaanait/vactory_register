var container = document.getElementsByClassName("box-wrapper")[0];
container.onkeyup = function(e) {
   if(e.target.value != ''){
    current_id = e.target.id;
    last_char = current_id.slice(-1);
    res = current_id.replace(last_char, Number(last_char)+1);
    next = document.getElementById(res)
    if(next != null) next.focus()
   }
   
}