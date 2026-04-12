# Security Policy

## Supported Versions

The project currently supports security fixes on the `main` branch.

## Reporting a Vulnerability

Please do not open public issues for suspected vulnerabilities.

Use one of these channels:
1. GitHub Security Advisories (preferred): open a private report from the repository Security tab.
2. If private reporting is unavailable, contact the maintainer directly and include:
   - clear reproduction steps
   - affected endpoint/file
   - potential impact
   - proof-of-concept (if available)

## What to Expect

- Initial acknowledgement target: within 72 hours.
- Triage and severity assessment after acknowledgement.
- Fix development and coordinated disclosure timeline shared once validated.

## Scope

In-scope examples:
- Authentication/authorization bypass
- Injection issues (SQL/command/template)
- SSRF, CSRF, XSS with practical impact
- Secret leakage
- Dependency vulnerabilities affecting runtime security

Out of scope examples:
- Purely informational issues without practical impact
- UI-only bugs without security implications
