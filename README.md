# ChatGPT Extract Translate/Transcript from Uploaded Audio and Chat with AI about Translate/Transcript. 

[![Downloads](https://poser.pugx.org/ShababSoftwares/ChatGPT-Describe-Audio-and-Chat-with-AI/d/total.svg)](https://github.com/ShababSoftwares/ChatGPT-Describe-Audio-and-Chat-with-AI)
[![License](https://poser.pugx.org/ShababSoftwares/ChatGPT-Describe-Audio-and-Chat-with-AI/license.svg)](LICENSE.md)

This is Laravel Project, You can submit any Audio file, AI will transcript it, and you can further ask Question about this Audio script.

## How to Use it

Just Download and run 

```bash
composer create-project shababsoftwares/chatgpt-describe-audio-and-chat-with-ai
```

## Setting up .env file

###setup database in .env file

import database_chatgpt.sql file into database, File Located under 'database/database_chatgpt.sql'

### You will need to add ChatGPT4 API Key in .env file

Obtain key from the link <a href="https://platform.openai.com/api-keys" target="_blank">ChatGPT API Key</a> and add into .env file like below.

`OPENAI_API_KEY=sk-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx`
    
## How to RUN

run following commands

```bash
    composer install
```
```bash
    php artisan serve
```

## How to Login

`http://localhost:8000/login`

Login Details:

Email - chatgpt@test.com
Pass: - Abc12345

## Upload Audio File

Upload any audio file from the menu, after uploading you will be redirected to Extracted content from audio file.
Here you can ask anything about extracted content from the audio, Like any thing.

## Access to Uploaded file section

You can see previous uploaded audio files, and chat history, and come back anytime to start conversation with AI.

## License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.

## Shabab Softwares

<p align="center"><a href="https://www.shababsoftwares.com" target="_blank">www.shababsoftwares.com</a></p>

Shabab Softwares (c) 2024
