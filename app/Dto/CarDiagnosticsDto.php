<?php

namespace App\Dto;

class CarDiagnosticsDto extends AbstractDto
{
    public int $id;
    public int $carId;
    public int $speed;
    public int $rpm;
    public int $fuelPercentage;
    public int $coolantTemperature;
    public string $createdAt;
}