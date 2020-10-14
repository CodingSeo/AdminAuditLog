<?php

namespace Hiworks\AdminAuditLogProducer\Enums;

use MyCLabs\Enum\Enum;

/**
 * Config파일로 이동
 */
class MenuCodeType extends Enum
{
	const ENVIRONMENT = 'environment';
    const TEAM_MAIL = 'team_mail';
    const MAIL = 'mail';
    const SECURITY = 'security';
    const BOARD = 'board';
    const MESSAGING = 'messaging';
    const BOOKING = 'boooking';
    const INSA = 'insa';
    const APPROVAL = 'approval';
    const BILL = 'bill';
    const ARCHIVE = 'archive';
}