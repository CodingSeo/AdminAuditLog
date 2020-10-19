# Admin Audit Log Producer

## 설명
어드민 감사 이벤트 처리 Json String Builder


## Install
composer install 

## Usage
> **Note:** This version of this SDK for PHP requires **PHP 5.6** or greater.

```php
try {
     date_default_timezone_set('UTC');
     $admin_audit_builder = new AdminAuditLogBuilder();
     $admin_audit_dto = $admin_audit_builder->setConfig(new AdminAuditLogConfig_V1())
         ->loadAdminAuditLogDTO()
         ->setMenu(MenuCodeType::APPROVAL)
         ->setLevel(LevelType::A)
         ->setAccessIp('127.0.0.1')
         ->setUserName('김**')
         ->setOfficeNum(123)
         ->setUserId('test_user')
         ->setUserNum(123)
         ->setEngFullMessage('This is Full Eng Message')
         ->setEngMessage('This is Short Eng Message')
         ->setShortMessage('This is Short Kor Message')
         ->setFullMessage('This is Full Kor Message')
         ->build();
 }
 catch (Exception $e){
     //Arguments that's not filled in the builder will be stacked here.
     var_dump($e->getMessage());
 }
```
