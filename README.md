# Notification Service

## Installation
First build project
```
make build
```
Install dependencies
```
make bash
composer install
composer console doctrine:mongodb:fixtures:load 
```
Load fixtures
```
make bash
composer console doctrine:mongodb:fixtures:load 
```
Add credentials to providers and configure `.env` :
```
#Enabled providers:
MAILGUN_ENABLED=true
TWILIO_ENABLED=true
AMAZON_SES_ENABLED=false
```
Consume notifications
1. Via console
```
make bash
composer consume
```
2. Via supervisord, uncomment lines for process:
```
docker/php/supervisord.conf
#[program:messenger-consume]

```
## Supported providers
1. Mailgun
```
MAILGUN_API_KEY=
MAILGUN_DOMAIN=
```
2. TWILIO
```
TWILIO_SID=
TWILIO_TOKEN=
TWILIO_PHONE=
```
3. Aws SES
```
Can be enabled only on AWS cloud
```

## Send strategies
```
Change
services.yaml
    App\Domain\Strategy\ProviderStrategy: '@App\Domain\Strategy\FirstAvailableProviderStrategy'
    OR
    App\Domain\Strategy\ProviderStrategy: '@App\Domain\Strategy\AllAvailableProviderStrategy'
```
