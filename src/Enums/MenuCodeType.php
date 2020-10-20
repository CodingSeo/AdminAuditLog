<?php

namespace Hiworks\AdminAuditLogBuilder\Enums;

use MyCLabs\Enum\Enum;

class MenuCodeType extends Enum
{
	const ENVIRONMENT = 'environment';
    const TEAM_MAIL = 'team-mail';
    const MAIL = 'mail';
    const SECURITY = 'security';
    const BOARD = 'board';
    const MESSAGING = 'messaging';
    const BOOKING = 'booking';
    const INSA = 'insa';
    const APPROVAL = 'approval';
    const BILL = 'bill';
    const ARCHIVE = 'archive';
    const API = 'api';
}