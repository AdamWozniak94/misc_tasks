<?php

/*
Chcemy stworzyć aplikację do ankietowania klientów.
Proszę zaprojektować strukturę DTO dla takiej aplikacji. 
Celem zadania nie jest zaprojektowanie bazy danych, lecz struktury obiektów, które będą zwracane na frontend podczas żądań do API. Choć oczywiście do pewnego stopnia te rzeczy są podobne.
Oto główne założenia aplikacji:

Pytań może być wiele rodzajów:
- pytania otwarte
- pytania tak / nie
- pytania tak / nie / nie wiem
- ocena w skali 1 - 10 (w tym skrajne odpowiedzi mają swoje opisy, np. dobrze/źle lub szybko/wolno)
- ocena w skali 1 - 5

Jedna ankieta może składać się z dowolnej ilości pytań dowolnego rodzaju.

Ankiet w całej aplikacji może być dużo. Ankety mają swój czas trwania (data od - data do)

Aplikacja z założenia tworzy ankiety anonimowe, tzn. nie trzeba się autoryzować aby odpowiedzieć na pytanie.

Proszę nie implementować żadnej funkcjonalności, wystarczą same klasy. Mile widziane jest użycie klas abstrakcyjnych.
*/

class Poll {
    function __construct(
        private int $id,
        private Datetime $startDate,
        private Datetime $endDate,
    ) {}
}

abstract class AbstractQuestion
{
    function __construct(
        protected int $id,
        protected int $pollId,
        protected int $type,
        protected string $description
    ) {}
}

class Question extends AbstractQuestion
{
    private const TYPE_OPEN = 0;
    private const TYPE_YES_NO = 1;
    private const TYPE_YES_NO_NEUTRAL = 2;

    function __construct(
        $id,
        $pollId,
        $description,
        $type
    ) {
        parent::__construct($id, $pollId, $type, $description);
    }
}

class ScaleQuestion extends AbstractQuestion
{
    function __construct(
        $id,
        $pollId,
        $description,
        private int $scaleMin,
        private int $scaleMax,
        // opcjonalne opisy skrajnych odpowiedzi
        private ?string $descMin = null,
        private ?string $descMax = null,

    ) {
        parent::__construct($id, $pollId, 3, $description);
    }
}

// Miejsce na więcej rodzajów pytań...

// class Answer
// {
//     function __construct(
//         private int $questionId,
//         private string $value // string może być przekonwertowany na int i bool
//     ) {}
// }
