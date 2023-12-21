<?php
namespace Package\R3m\Io\Autoload\Trait;

use R3m\Io\App;

use R3m\Io\Module\Core;
use R3m\Io\Module\File;

use R3m\Io\Node\Model\Node;

use Exception;
trait Import {

    public function role_system(): void
    {
        $object = $this->object();
        $node = new Node($object);
        $node->role_system_create('r3m_io/autoload');
    }

    /**
     * @throws Exception
     */
    public function autoload(): void
    {
        $object = $this->object();
        $options = App::options($object);
        $class = 'System.Autoload';
        $options->url = $object->config('project.dir.vendor') .
            'r3m_io/autoload/Data/' .
            $class .
            $object->config('extension.json')
        ;
        $node = new Node($object);
        $response = $node->import($class, $node->role_system(), $options);
        $this->stats($class, $response);
    }

    /**
     * @throws Exception
     */
    public function autoload_prefix(): void
    {
        $object = $this->object();
        $options = App::options($object);
        $class = 'System.Autoload.Prefix';
        $options->url = $object->config('project.dir.vendor') .
            'r3m_io/autoload/Data/' .
            $class .
            $object->config('extension.json')
        ;
        $node = new Node($object);
        $response = $node->import($class, $node->role_system(), $options);
        $this->stats($class, $response);
    }

    /**
     * @throws Exception
     */
    public function config_autoload(): void
    {
        $object = $this->object();
        $options = App::options($object);
        $class = 'System.Config';
        $node = new Node($object);
        $response = $node->record($class, $node->role_system(), []);
        if(
            $response &&
            is_array($response) &&
            array_key_exists('node', $response) &&
            property_exists($response['node'], 'uuid')
        ){
            $patch = (object) [
                'uuid' => $response['node']->uuid,
                'autoload' => '*'
            ];
            $response = $node->patch($class, $node->role_system(), $patch);
            ddd($response);
        }
        ddd($response);
        $this->stats($class, $response);
    }

    public function stats($class, $response): void
    {
        if(
            $response &&
            array_key_exists('create', $response) &&
            array_key_exists('put', $response) &&
            array_key_exists('patch', $response) &&
            array_key_exists('commit', $response) &&
            array_key_exists('speed', $response['commit']) &&
            array_key_exists('item_per_second', $response)
        ) {
            $total = $response['create'] + $response['put'] + $response['patch'];
            if ($total === 1) {
                echo 'Imported ' .
                    $total .
                    ' (create: ' .
                    $response['create'] .
                    ', put: ' .
                    $response['put'] .
                    ', patch: ' .
                    $response['patch'] .
                    ') item (' .
                    $class .
                    ') at ' .
                    $response['item_per_second'] .
                    ' items/sec (' .
                    $response['commit']['speed'] . ')' .
                    PHP_EOL;
            } else {
                echo 'Imported ' .
                    $total .
                    ' (create: ' .
                    $response['create'] .
                    ', put: ' .
                    $response['put'] .
                    ', patch: ' .
                    $response['patch'] .
                    ') items (' .
                    $class .
                    ') at ' .
                    $response['item_per_second'] .
                    ' items/sec (' .
                    $response['commit']['speed'] . ')' .
                    PHP_EOL;
            }
        }
    }

    /**
     * @throws Exception
     */
    public function event(): void
    {
        $object = $this->object();
        $options = App::options($object);
        $class = 'System.Event';
        $options->url = $object->config('project.dir.vendor') .
            'r3m_io/event/Data/' .
            $class .
            $object->config('extension.json')
        ;
        $node = new Node($object);
        $response = $node->import($class, $node->role_system(), $options);
        if(
            $response &&
            array_key_exists('create', $response) &&
            array_key_exists('put', $response) &&
            array_key_exists('patch', $response) &&
            array_key_exists('commit', $response) &&
            array_key_exists('speed', $response['commit']) &&
            array_key_exists('item_per_second', $response)
        ){
            $total = $response['create'] + $response['put'] + $response['patch'];
            if($total === 1){
                echo 'Imported ' .
                    $total .
                    ' (create: ' .
                    $response['create'] .
                    ', put: ' .
                    $response['put'] .
                    ', patch: ' .
                    $response['patch'] .
                    ') item (' .
                    $class .
                    ') at ' .
                    $response['item_per_second'] .
                    ' items/sec (' .
                    $response['commit']['speed'] . ')' .
                    PHP_EOL
                ;
            } else {
                echo 'Imported ' .
                    $total .
                    ' (create: ' .
                    $response['create'] .
                    ', put: ' .
                    $response['put'] .
                    ', patch: ' .
                    $response['patch'] .
                    ') items (' .
                    $class .
                    ') at ' .
                    $response['item_per_second'] .
                    ' items/sec (' .
                    $response['commit']['speed'] . ')' .
                    PHP_EOL
                ;
            }
        }
    }
}