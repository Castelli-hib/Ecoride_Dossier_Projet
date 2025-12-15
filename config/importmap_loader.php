<?php
use Symfony\WebpackEncoreBundle\Twig\StimulusTwigExtension;

$importmapPath = __DIR__ . '/importmap.php';

if (!file_exists($importmapPath)) {
    throw new \RuntimeException('Importmap introuvable dans app/config/importmap.php');
}

return require $importmapPath;
