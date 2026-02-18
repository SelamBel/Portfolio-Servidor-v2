<footer>
    <div class="footer-content">
        <div class="footer-brand">
            <h3>Contacto</h3>
            <p>+34 XXX XXX XXX <br>selambeljer@outlook.es <br>selbeljer@alu.edu.gva.es</p>

        </div>
        <div class="footer-column">
            <h4>Redes Sociales</h4>
            <a class="network" href="https://twitter.com" target="_blank" rel="nofollow"><img src="../static/img/iconos/twitter.svg" alt="Twitter"></a>
            <a class="network" href="https://www.linkedin.com/in/selam-bel" target="_blank" rel="nofollow"><img src="../static/img/iconos/linkedin.svg" alt="linkedin"></a>
            <a class="network" href="https://github.com/SelamBel" target="_blank" rel="nofollow"><img src="../static/img/iconos/github.svg" alt="github"></a>
        </div>
        <div class="footer-column">
            <h4>Portfolio</h4>
            <ul>
                <?php
                foreach ($categorias as $categoria) {
                    echo  "<li><a href='../proyectos.php?cat=" . $categoria . "' class='nav-link " . "'>" . $categoria . "</a>";
                }
                echo "</li>";
                ?>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 NOIR. Todos los derechos reservados. | Plantilla diseñada por <a href="https://templatemo.com/tm-599-noir-fashion" target="_blank" rel="nofollow" style="color: var(--accent); text-decoration: none;">TemplateMo</a> | Página creada por <a href="https://github.com/SelamBel" target="_blank" rel="nofollow" style="color: var(--accent); text-decoration: none;">Selam Bel</a></p>
    </div>
</footer>