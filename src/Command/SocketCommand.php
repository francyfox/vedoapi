<?php


namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// Include ratchet libs
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Group;
use App\Sockets\Chat;

class SocketCommand extends Command
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('sockets:start-chat')
            // the short description shown while running "php bin/console list"
            ->setHelp("Starts the vedofair chat")
            // the full command description shown when running the command with
            ->setDescription('Starts the vedofair chat')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '    |\__/,|   (`\ ',
            '  _.|o o  |_   ) )',
            '-(((---(((--------',
            'Ratchet Vedofair Started',// A line
            '============',// Another line
            'Socket chat online, open your browser.',// Empty line
        ]);

        $app = new \Ratchet\App('localhost', 8080, '127.0.0.1');
        $GroupTables = $this->em
            ->getRepository('App:Group')
            ->findAll();
        foreach ($GroupTables as $group) {
            $str = strtolower(str_replace(' ', '_', $group->getGroupName()));
            $pathToRoute = '/'.$str;
            $output->writeln($pathToRoute);
            $app->route($pathToRoute, new Chat);
        }

        $app->run();

//        $server = IoServer::factory(
//            new HttpServer(
//                new WsServer(
//                    new Chat()
//                )
//            ),
//            8080
//        );

    }
}