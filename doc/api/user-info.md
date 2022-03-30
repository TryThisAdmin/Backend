# Get User Information

> Returns information about a specific user.

- Endpoint: `/user`
- Method: `GET`
- Parameters:
    - `id` [required]
    - `token` [optional]
- Return:
    ```ts
    {
        entries: {
            name: string,
            id: string,
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
    curl "backend/user?id=1" 
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