<?php
class View
{
    private $page;

    public function build(string $viewName)
    {
        /*
        1. Comprobar el nombre de la vista.
        2. Si existe construir la vista en la propiedad $page,
           si no existe construir la vista 'notFoundView' en la propiedad $page.
        */
    }

    public function show()
    {
        /*
        1. Imprimir contenido de la propiedad $page.
        */
        echo $this->page;
    }
}
