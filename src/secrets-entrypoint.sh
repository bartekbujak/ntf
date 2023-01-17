#!/bin/bash

set -e

# Check that the environment variable has been set correctly
if [ -z "$SECRETS_BUCKET_NAME" ]; then
  echo 'missing SECRETS_BUCKET_NAME environment variable. Fallback to local.'
else
  echo 'Prepare env configuration'

  aws s3 cp s3://${SECRETS_BUCKET_NAME}/dd-static/.env .env
  echo 'Env file copied from s3 bucket.'
fi

exec "$@"
