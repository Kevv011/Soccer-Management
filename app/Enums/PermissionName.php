<?php

namespace App\Enums;

enum PermissionName: string
{
    case PanelAccess = 'panel.access';
    case CountriesViewAny = 'countries.view-any';
    case CountriesView = 'countries.view';
    case CountriesCreate = 'countries.create';
    case CountriesUpdate = 'countries.update';
    case CountriesDelete = 'countries.delete';
    case SubdivisionsViewAny = 'subdivisions.view-any';
    case SubdivisionsView = 'subdivisions.view';
    case SubdivisionsCreate = 'subdivisions.create';
    case SubdivisionsUpdate = 'subdivisions.update';
    case SubdivisionsDelete = 'subdivisions.delete';
    case FederationsViewAny = 'federations.view-any';
    case FederationsView = 'federations.view';
    case FederationsCreate = 'federations.create';
    case FederationsUpdate = 'federations.update';
    case FederationsDelete = 'federations.delete';
    case TeamsViewAny = 'teams.view-any';
    case TeamsView = 'teams.view';
    case TeamsCreate = 'teams.create';
    case TeamsUpdate = 'teams.update';
    case TeamsDelete = 'teams.delete';
    case PlayersViewAny = 'players.view-any';
    case PlayersView = 'players.view';
    case PlayersCreate = 'players.create';
    case PlayersUpdate = 'players.update';
    case PlayersDelete = 'players.delete';
    case RolesViewAny = 'roles.view-any';
    case RolesView = 'roles.view';
    case RolesCreate = 'roles.create';
    case RolesUpdate = 'roles.update';
    case RolesDelete = 'roles.delete';
    case PermissionsViewAny = 'permissions.view-any';
    case PermissionsView = 'permissions.view';
    case PermissionsCreate = 'permissions.create';
    case PermissionsUpdate = 'permissions.update';
    case PermissionsDelete = 'permissions.delete';
    case MediaManage = 'media.manage';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(
            static fn (self $permission): string => $permission->value,
            self::cases(),
        );
    }
}
