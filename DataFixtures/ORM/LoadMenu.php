<?php
namespace Black\Bundle\MenuBundle\DataFixtures;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use BlackEngine\Bundle\SimpleCmsBundle\Entity\Menu;

class LoadMenu implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for($i=0;$i<=30;$i++){
            $menu = new Menu();
            $menu->setName('Menu Test n°'.$i);
            $menu->setSlug('Menu Test n°'.$i);
            $manager->persist($menu);
            $manager->flush();
        }

    }
}
