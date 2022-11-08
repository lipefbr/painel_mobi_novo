<?php

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| O Composer fornece um carregador de classes conveniente e gerado automaticamente
| para a nossa aplicação. Nós apenas precisamos utilizá-lo! Vamos exigir
| no script aqui para que não tenhamos que nos preocupar com o
| carregamento de qualquer uma de nossas classes "manualmente". É ótimo relaxar.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Include The Compiled Class File
|--------------------------------------------------------------------------
|
| Para aumentar drasticamente o desempenho do seu aplicativo, você pode usar um
| arquivo de classe compilado que contém todas as classes comumente usadas
| por um pedido. O artesão "otimizar" é usado para criar este arquivo.
|
*/

$compiledPath = __DIR__.'/cache/compiled.php';

if (file_exists($compiledPath)) {
    require $compiledPath;
}
