<?php

namespace App\Enums;

enum RoleName: string
{
    case SuperAdmin = 'Super Admin';
    case PanelAdmin = 'Panel Admin';
    case FederationAdmin = 'Federation Admin';
    case Viewer = 'Viewer';
}
