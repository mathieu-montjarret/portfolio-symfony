<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CommentTest extends KernelTestCase
{
    public function getEntity(): Comment
    {
        return (new Comment())
            ->setName('John Doe')
            ->setDescription('This is a valid comment.')
            ->setCreatedAt(new \DateTimeImmutable());
    }

    public function assertHasErrors(Comment $comment, int $number = 0)
    {
        self::bootKernel();
        $container = static::getContainer();
        $errors = $container->get('validator')->validate($comment);
        $this->assertCount($number, $errors);
    }

    public function testValidComment()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidBlankName()
    {
        $comment = $this->getEntity()->setName('');
        $this->assertHasErrors($comment, 1);
    }

    public function testInvalidBlankDescription()
    {
        $comment = $this->getEntity()->setDescription('');
        $this->assertHasErrors($comment, 1);
    }

    public function testInvalidDescriptionWithSpecialCharacters()
    {
        $comment = $this->getEntity()->setDescription('Invalid description with #$%^&*');
        $this->assertHasErrors($comment, 1);
    }
}
