<?php

namespace App\Dto;

class CarDto extends AbstractDto
{
    public ?int $id;
    public string $name;
    public string $brand;
    public string $model;
    public string $vin;
    public string $registrationNumber;
    public string $productionYear;
}