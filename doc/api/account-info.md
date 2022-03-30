# Get Account Information

> Returns account information.

- Endpoint: `/account`
- Method: `GET`
- Parameters:
    - `token` [required]
- Return:
    ```ts
    {
        entries: {
            name: string,
            id: string,
            email: string,
            role: string,
            following: string,
            followers: string,
            ideaLikes: string,
            commentLikes: string,
            ideas: string,
            comments: string
        }[]
    }
    ```

---

## Example (Curl)

- Request:
    ```sh
    curl "backend/account?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiIxIiwicm9sZSI6ImFkbWluIiwiZXhwIjoiMjAyMi0wMS0wMSAwMDowMDowMCJ9.pXj82eZW-VXjYgIx1L9GrHWn-tcvNg-_mGpEBySaKAg" 
        -X GET
    ```
- Answer:
    ```json
    {
        "entries": [
            {
                "name": "User1",
                "id": "1",
                "email": "some@mail.com",
                "role": "admin",
                "following": "",
                "followers": "12",
                "ideaLikes": "10",
                "commentLikes": "8",
                "ideas": "18",
                "comments": "34"
            }
        ]
    }
    ```