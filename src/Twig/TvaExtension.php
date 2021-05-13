<?php
// src/Twig/TvaExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TvaExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(new TwigFilter('tva', array($this,'calculTva')));
    }
    
    function calculTva($prixHT,$tva)
    {
        return round($prixHT / $tva,2);
    }
}