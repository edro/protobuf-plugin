<?php

namespace Protobuf\Compiler\Generator\Message;

use Protobuf\Compiler\Entity;
use Protobuf\Compiler\Generator\BaseGenerator;
use Protobuf\Compiler\Generator\GeneratorVisitor;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\GeneratorInterface;
use Zend\Code\Generator\MethodGenerator;

/**
 * Message fromStream generator
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class FromStreamGenerator extends BaseGenerator implements GeneratorVisitor
{
    /**
     * {@inheritdoc}
     */
    public function visit(Entity $entity, GeneratorInterface $class)
    {
        if ($class instanceof ClassGenerator) {
            $class->addMethodFromGenerator($this->generateMethod($entity));
        }
    }

    /**
     * @return string[]
     */
    public function generateBody()
    {
        return [
            'return new self($stream, $configuration);',
        ];
    }

    /**
     * @param \Protobuf\Compiler\Entity $entity
     *
     * @return string
     */
    protected function generateMethod(Entity $entity)
    {
        $lines = $this->generateBody();//$entity);
        $body = implode(PHP_EOL, $lines);
        $method = MethodGenerator::fromArray(
            [
                'name'       => 'fromStream',
                'body'       => $body,
                'static'     => true,
                'parameters' => [
                    [
                        'name' => 'stream',
                        //'type'          => 'mixed',
                    ],
                    [
                        'name'         => 'configuration',
                        'type'         => '\Protobuf\Configuration',
                        'defaultValue' => null,
                    ],
                ],
                'docblock'   => [
                    'shortDescription' => "{@inheritdoc}",
                ],
            ]);

        return $method;
    }
}
