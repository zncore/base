<?php

namespace ZnCore\Base\Tests\Unit;

use ZnCore\Base\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Base\Domain\Helpers\EntityHelper;
use ZnCore\Base\Domain\Helpers\ValidationHelper;
use ZnCore\Base\Tests\Libs\AccessEntity;
use ZnTool\Test\Base\BaseTest;

final class EntityValidateTest extends BaseTest
{

    public function testSuccess()
    {
        $entity = new AccessEntity;
        $entity->setProjectId(1);
        $entity->setUserId(2);

        ValidationHelper::validateEntity($entity);
        $this->assertTrue(true);
    }

    public function testRequired()
    {
        $entity = new AccessEntity;

        //$this->expectException(UnprocessibleEntityException::class);

        $expected = [
            [
                'field' => 'userId',
                'message' => 'This value should not be blank.',
            ],
            [
                'field' => 'projectId',
                'message' => 'This value should not be blank.',
            ],
        ];
        try {
            ValidationHelper::validateEntity($entity);
        } catch (UnprocessibleEntityException $e) {
            $this->assertUnprocessibleEntityException($expected, $e);
        }
    }

    public function testInvalidType()
    {
        $entity = new AccessEntity;
        $entity->setProjectId('qwer');
        $entity->setUserId(2);

        $expected = [
            [
                "field" => "projectId",
                "message" => "This value should be positive.",
            ],
        ];
        try {
            ValidationHelper::validateEntity($entity);
        } catch (UnprocessibleEntityException $e) {
            $this->assertUnprocessibleEntityException($expected, $e);
        }
    }

    public function testInvalidRange()
    {
        $entity = new AccessEntity;
        $entity->setProjectId(-3);
        $entity->setUserId(2);

        $expected = [
            [
                'field' => 'projectId',
                'message' => 'This value should be positive.',
            ],
        ];
        try {
            ValidationHelper::validateEntity($entity);
        } catch (UnprocessibleEntityException $e) {
            $this->assertUnprocessibleEntityException($expected, $e);
        }
    }

}