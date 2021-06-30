<?php

namespace Daijulong\Painter\Contacts;

interface ElementContacts
{
    public function paste();

    public function getWidth(): int;

    public function getHeight(): int;

    public function getX(): int;

    public function getY(): int;

    public function getBottomY(): int;
}