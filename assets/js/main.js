// alert('Estoy corriendo');

/* -- Profile Users -- */
let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () => {
	// alert('Onclick ejecutado');
	profile.classList.toggle('active');
	navbar.classList.remove('active');
};

/* -- Navbar -- */
let navbar = document.querySelector('.header .flex .navbar');

document.querySelector('#menu-btn').onclick = () => {
	// alert('Onclick ejecutado');
	navbar.classList.toggle('active');
	profile.classList.remove('active');
};

window.onscroll = () => {
	profile.classList.remove('active');
	navbar.classList.remove('active');
};
