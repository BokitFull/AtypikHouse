let login_div = document.querySelector('#login_div');
let login_form = login_div.querySelector('#login_form');
let register_form = login_div.querySelector('#register_form');
let forgot_password_form = login_div.querySelector('#forgot_password_form');
let login_form_btn = login_div.querySelector('#login_form_btn');
let register_form_btn = login_div.querySelector('#register_form_btn');
let forgot_password_form_btn = login_div.querySelector('#forgot_password_form_btn');
let form_submit_btn = login_div.querySelector('#form_submit_btn');
let login_btn_div = document.querySelector('#login_btn_div');

login_btn_div.addEventListener('click', (e)=>{
    if (e.target == login_form_btn){
        register_form.style.display = 'none';
        register_form_btn.style.display = 'block';
        login_form_btn.style.display = 'none';
        login_form.style.display = 'flex';
        form_submit_btn.innerHTML = "Connexion";
        form_submit_btn.setAttribute('form', 'login_form');
        // forgot_password_form.style.display = 'none';
    }

    if (e.target == register_form_btn){
        login_form.style.display = 'none';
        register_form_btn.style.display = 'none';
        login_form_btn.style.display = 'block';
        register_form.style.display = 'flex';
        form_submit_btn.innerHTML = "Inscription";
        form_submit_btn.setAttribute('form', 'register_form');
        // forgot_password_form.style.display = 'none';
    }

    // if (e.target == forgot_password_form_btn){
    //     login_form_btn.style.display = 'none';
    //     register_form.style.display = 'none';
    // }
})
