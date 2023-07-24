/*==============for the testimonial=============*/
let usertexts = document.getElementsByClassName("user-text");
let userpics = document.getElementsByClassName("circle");
show();
function show(){
   
 
    let i= Array.from(userpics);
    i.forEach(cell => cell.addEventListener("click", cellClicked));
 
}
function cellClicked(){

    const i = this.getAttribute("cellIndex");
    for(let userpic of userpics){
        userpic.classList.remove("active-pic");
    }
    for(let usertext of usertexts)
    {
        usertext.classList.remove("active-text");
    }
    userpics[i].classList.add("active-pic");
    usertexts[i].classList.add("active-text");
}



