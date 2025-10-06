<?php

/**
 * @var \Amazing79\Simplex\Simplex\Renders\HtmlLayoutRender $this
 */
// $this->loadScript('/js/mi.js', 'attributes');
?>
<style>
    /** estilos solo aplicables a este template **/
    .m_layout{
        display:flex;
        flex-direction:column;
        width:100%;
        margin:0 auto;
        max-width:960px;
        gap: 20px;
    }

    p{
        text-align:center;
        font-weight: bold;
        color:#304c7c;
    }

</style>
<section class="m_layout">
    <h1>Layout de Ejemplo</h1>
    <p>Este template es para ver como podemos usarlo, y mantener toda la estructura principal del sitio dentro de layout</p>
    <p>Si esta plantilla requiere js particular, lo podremos incorporar sin problemas (m&eacute;tedo loadScript)</p>
    <p>Para modificar el layout general, debemos editar el template provisto en View/layout/layout.php</p>
    <p>Además, se brinda un css m&iacute;nimo para usar con dicho layout (app.css). ¡Modificar a piacere!</p>
</section>
