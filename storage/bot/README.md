# Bot TLS material

`privkey1.pem` and `fullchain1.pem` are intentionally not tracked. Supply them at deploy time via a secret/volume and point `SSL_KEY_PATH` / `SSL_CERT_PATH` at their mounted paths in `.env`. The previously committed certificate expired in March 2020 and must not be reused.
