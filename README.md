# Admin Audit Log Builder

## 설명
어드민 감사 이벤트 처리 Json String Builder

## Install
```composer log
"require": {
        "hiworks/admin-audit-log-builder": "^1.0"
}
```
## Requirement

myclabs/php-enum : 1.6.6

hiworks/kafka-producer : 1.0.4

## Usage
> **Note:** This version of this SDK for PHP requires **PHP 5.6** or greater.

```php
try {
    $admin_audit_log = AdminAuditLog::builder('v1')
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
    $admin_audit_log_producer = new AdminAuditLogKafkaProducer();

    //Logging if needed
    //$logger = new Logger('my_logger');
    //$admin_audit_log_producer->setLogger($logger);

    //Setting kafka_config if needed
    //$kafka_config = $admin_audit_log_producer->getKafkaConfig();
    //$kafka_config->setRequireAck(1);

    $admin_audit_log_producer->setBootstrapServer("kafka01:9092,kafka02:9092,kafka03:9092");
    $admin_audit_log_producer->sendMessage('tracking.admin.audit',$admin_audit_log);
}catch(Exception $e){
    var_dump(get_class($e) . " : " . $e->getMessage());
}
```
## 


## Test Cases
>./vendor/bin/phpunit --testsuite builder

admin_audit_log_builder test
