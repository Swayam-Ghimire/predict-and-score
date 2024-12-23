const register=document.getElementById("registerButton");
const login=document.getElementById("logInButton");
const registerForm=document.getElementById("register");
const loginForm=document.getElementById("login");

register.addEventListener('click', function(){
    registerForm.style.display='block';
    loginForm.style.display='none';
})
login.addEventListener('click', function(){
    registerForm.style.display="none";
    loginForm.style.display="block";
})