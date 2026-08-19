#!/usr/bin/env bash
set -euo pipefail

if [[ $# -ne 1 ]]; then
  echo "Usage: $0 <alb-dns-name>" >&2
  exit 1
fi

alb_dns="$1"
url="http://${alb_dns}/health.html"

echo "Checking ${url}"
response="$(curl --fail --silent --show-error --max-time 15 "${url}")"

if [[ "${response}" != "healthy" ]]; then
  echo "Unexpected response: ${response}" >&2
  exit 1
fi

echo "Validation passed: ALB returned healthy"

