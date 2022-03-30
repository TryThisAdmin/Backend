# Account Recovery

> Generates a new password and sends it via email to the accounts email adress

- Endpoint: `/user/recovery`
- Method: `POST`
- Parameters:
    - `email` [required]
- Return:
    ```ts
    {}
    ```

---

## Example (Curl)

- Request:
    ```sh
    curl "backend/user/recovery" 
        -X POST
        -F email=some@mail.com
    ```
- Answer:
    ```json
    {}
    ```