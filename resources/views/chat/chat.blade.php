<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat rede social</title>
    <link rel="stylesheet" href="{{url('assets/css/chat.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    @extends('layouts.menu')

    <div class="chat-user-friend">
        <div class="leftbar">
            <div class="chat-header friends-list"><h4>Conexões</h4></div>
            <div class="search">
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquisar">
            </div>
            <div class="online-list">
                <div class="online">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>
                    <p>Goel nkoko</p>
                </div>
                <h6>online agora</h6>

            </div>
            <div class="online-list">
                <div class="online">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>
                    <p>Goel nkoko</p>

                </div>
                <h6>online há 16 min</h6>
            </div>
            <div class="online-list">
                <div class="online">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>
                    <p>Goel nkoko</p>

                </div>
                <h6>online há 1h</h6>
            </div>
             <div class="online-list">
                <div class="online">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>
                    <p>Goel nkoko</p>

                </div>
                <h6>online agora</h6>


            </div>
        </div>


        <div class="chat-container">
            <div class="chat-header friend-profile">
                <div><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                  </svg></div>
                <div><h4>Gyomei Himejima</h4></div>
            </div>
            <div class="chat-messages">
                <div class="message user">
                    <div class="message-text">Hey Rafa, tudo bem?</div>
                    <div class="message-times">10:30 AM</div>
                </div>
                <div class="message friend">
                    <div class="message-text">tudo bem, apenas vivendo o meu sonho, e tu?</div>
                    <div class="message-times">10:35 AM</div>
                </div>
                <div class="message user">
                    <div class="message-text">Hey Rafa, tudo bem com a tia?</div>
                    <div class="message-times">10:30 AM</div>
                </div>
                <div class="message friend">
                    <div class="message-text">tudo bem, apenas vivendo o meu sonho, e tu?</div>
                    <div class="message-times">10:35 AM</div>
                </div>
                <div class="message friend">
                    <div class="message-text">tudo bem, apenas vivendo o meu sonho, e tu?</div>
                    <div class="message-times">10:35 AM</div>
                </div>
            </div>
            <form class="input-form">
                <textarea id="message-text" name="story" rows="1" cols="33" placeholder="Mensagem"></textarea>
                <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-images" viewBox="0 0 16 16">
                    <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                    <path d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2M14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1M2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1z"/>
                  </svg>
                </div>
                <button id="btn-send" type="submit" class="button send-button">></button>
            </form>
        </div>

    </div>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
