#Admin Audit Log Producer

어드민 감사 이벤트 처리 Producer  

## Install

## Usage
> **Note:** Note: This version of this SDK for PHP requires **PHP 5.6** or greater.

```php
date_default_timezone_set('PRC');
$admin_audit_builder = new Hiworks\AdminAuditLogProducer\Builder\AdminAuditLogBuilder();
$admin_audit_dto = $admin_audit_builder->setConfig(new AdminAuditLogConfig_V1())
    ->loadAdminAuditLogDTO()
    ->setMenu(MenuCodeType::APPROVAL)
    ->setAccessIp('1.1.1.1')
    ->setUserName('test')
    ->setOffice(123)
    ->setUserId('tets')
    ->setUserNumber(123)
    ->setEngFullMessage('t')
    ->setEngMessage('t')
    ->setShortMessage('t')
    ->setFullMessage('t')
    ->setLevel(LevelType::A)
    ->build();
```
