# List Users

> Lists all existing users
>
> Can only be called by administrators

- Endpoint: `/user/all`
- Method: `GET`
- Parameters:
    - `token` [required]
- Return:
    ```ts
    {
        entries: {
            name: string,
            id: string,
            role: string,
            email: string
        }[]
    }
    ```

---

## Example (Curl)

- Request:
    ```sh
    curl "backend/user/all?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiIxIiwicm9sZSI6ImFkbWluIiwiZXhwIjoiMjAyMi0wMS0wMSAwMDowMDowMCJ9.pXj82eZW-VXjYgIx1L9GrHWn-tcvNg-_mGpEBySaKAg" 
        -X GET
    ```
- Answer:
    ```json
    {
        "entries": [
            {
                "name": "User1",
                "id": "1",
                "role": "admin",
                "email": "some@mail.com"
            },
            {
                "name": "User2",
                "id": "2",
                "role": "user",
                "email": "other@mail.com"
            },
            {
                "name": "User3",
                "id": "3",
                "role": "user",
                "email": "another@mail.com"
            }
        ]
    }
    ```