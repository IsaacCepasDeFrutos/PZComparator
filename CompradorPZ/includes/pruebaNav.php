<header>
  <div class="container">
    <div class="logo">
      <img src="logoPZ.png" alt="Logo">
    </div>
    <nav>
    <div class="menu-barras" onclick="toggleMenu()"> 
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
      </div>
      <ul class="menu" id="menu">
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Galeria</a></li>
        <li><a href="#">Contacto</a></li>        
        <li><a href="#">Registrarse</a></li>
      </ul>
      
    </nav>
  </div>
</header>



<style>
.container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
}

.logo img {
  max-width: 150px;
}

.menu {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

.menu li {
  display: inline;
  margin-left: 20px;
}

.menu li a {
  text-decoration: none;
  color: #333;
}

.menu-barras {
  display: none;
  cursor: pointer;
}

@media  (max-width: 768px) {
  .container {
    flex-direction: column;
    align-items: flex-start;
  }

  .menu {
    display: none;
    width: 100%;
    text-align: center;
    transition: all 0.3s ease;
  }

  .menu.show {
    display: block;
  }

  .menu li {
    display: block;
    margin: 10px 0;
  }

  .menu-barras {
    display: block;
    margin-top: 10px;
  }

  .menu-barras .bar {
    width: 25px;
    height: 3px;
    background-color: #333;
    margin: 5px 0;
    transition: transform 0.3s ease;
  }

  .menu-barras.abierto .bar:nth-child(1) {
    transform: rotate(-45deg) translate(-5px, 6px);
  }

  .menu-barras.abierto .bar:nth-child(2) {
    opacity: 0;
  }

  .menu-barras.abierto .bar:nth-child(3) {
    transform: rotate(45deg) translate(-5px, -6px);
  }
}
</style>

<script>
function toggleMenu() {
  const menu = document.getElementById('menu');
  const menuToggle = document.querySelector('.menu-barras');
  menu.classList.toggle('show');
  menuToggle.classList.toggle('abierto');
}
</script>