<script>
    const vocabulary = {
        title: {
            ru: "Заглавок",
            ua: "Заголовок"
        },
        menu_areas: {
            ru: "Направления деятельности",
            ua: "Напрямки діяльності"
        },
        menu_masters: {
            ru: "Мастера",
            ua: "Майстри"
        },
        menu_studies: {
            ru: "Обучения",
            ua: "Навчання"
        },
        menu_info: {
            ru: "Полезная информация",
            ua: "Корисна інформація"
        },
        menu_events: {
            ru: "События",
            ua: "Події"
        },
        menu_register: {
            ru: "Регистрация",
            ua: "Реєстрація"
        },
        menu_login: {
            ru: "Вход",
            ua: "Вхід"
        },
        menu_logout: {
            ru: "Выйти",
            ua: "Вийти"
        },
        menu_notes_to_chief:{
            ru: "Мои записи",
            ua: "Мої записи"
        },
        popup_register_title: {
            ru: "Регистрация",
            ua: "Реєстрація"
        },
        popup_register_name: {
            ru: "Имя",
            ua: "Ім'я"
        },
        popup_register_last_name: {
            ru: "Фамилия",
            ua: "Прізвище",
        },
        popup_register_email : {
            ru: "Почта",
            ua: "Пошта"
        },
        popup_register_phone: {
            ru: "Телефон",
            ua: "Телефон"
        },
        popup_register_social_type: {
            ru: "Выберите соц. сеть",
            ua: "Оберіть соц. мережу"
        },
        popup_register_social_phone : {
            ru: "Телефон соц. сети",
            ua: "Телефон соц. мережі"
        },
        popup_register_password : {
            ru: "Пароль",
            ua: "Пароль"
        },
        popup_register_password_confirmation: {
            ru: "Повторите пароль",
            ua: "Повторіть пароль"
        },
        popup_register_submit: {
            ru: "Зарегистрироваться",
            ua: "Зареєструватись"
        },
        popup_login_title: {
            ru: "Вход",
            ua: "Вхід"
        },
        popup_login_email: {
            ru: "Почта",
            ua: "Пошта"
        },
        popup_login_password: {
            ru: "Пароль",
            ua: "Пароль"
        },
        popup_login_submit: {
            ru: "Войти",
            ua: "Увійти"
        },
        popup_login_register: {
            ru: "Регистрация",
            ua: "Реєстрація"
        },
        popup_login_forget_password: {
            ru: "Забыли пароль?",
            ua: "Забули пароль?"
        },
        popup_forget_password_title: {
            ru: "Забыли пароль?",
            ua: "Забули пароль?"
        },
        popup_forget_password_text: {
            ru: "На указаную вами почту придет письмо для сброса пароля. Если вы не увидите письмо, проверьте пожалуйста спам.",
            ua: "На вказану вами пошту прийде лист для скидання паролю. Якщо ви не побачите листа, то перевірте будь-ласка спам."
        },
        popup_forget_password_email: {
            ru: "Почта",
            ua: "Пошта"
        },
        popup_forget_password_submit: {
            ru: "Отправить",
            ua: "Відправити"
        },
        reset_password_title: {
            ru: "Cброс пароля",
            ua: "Скидання пароля"
        },
        reset_password_email: {
            ru: "Почта",
            ua: "Пошта"
        },
        reset_password_password: {
            ru: "Пароль",
            ua: "Пароль"
        },
        reset_password_confirmation: {
            ru: "Повторите пароль",
            ua: "Повторіть пароль"
        },
        reset_password_submit: {
            ru: "Сбросить пароль",
            ua: "Скинути пароль"
        },
        masters_title: {
            ru: "Мастеры",
            ua: "Майстри"
        },
        masters_master_details : {
            ru: "Больше о мастере",
            ua: "Більше про майстра"
        },
        master_login: {
            ru: "Войти",
            ua: "Увійти"
        },
        master_enrol: {
            ru: "Записаться",
            ua: "Записатись"
        },
        master_reviews: {
            ru: "Отзывы",
            ua: "Відгуки"
        },
        master_review_text: {
            ru: "Оставьте свой отзыв",
            ua: "Залиште свій відгук"
        },
        master_send_review: {
            ru: "Оправить",
            ua: "Відправити"
        },
        popup_master_enrol_title: {
            ru: "Запись к",
            ua: "Запис до"
        },
        popup_master_enrol_name: {
            ru: "Запись на имя: ",
            ua: "Запис на ім'я: "
        },
        popup_master_enrol_text_one: {
            ru: "Отслеживайте статус записи на странице \"Мои записи\" в меню",
            ua: "Відслідковуйте статус запису на сторінці \"Мої записи\" в меню"
        },
        popup_master_enrol_text_two: {
            ru: "Вам перезвонят, когда администратор рассматрит вашу запись",
            ua: "Вам передзвонять, коли адміністратор розгляне ваш запис"
        },
        popup_master_enrol_submit: {
            ru: "Записаться",
            ua: "Записатись"
        },
        studies_title: {
            ru: "Обучения",
            ua: "Навчання"
        },
        popup_studies_title: {
            ru: "Запись на обучение",
            ua: "Запис на навчання"
        },
        popup_studies_name: {
            ru: "Запись на имя:",
            ua: "Запис на ім'я"
        },
        popup_studies_text_one: {
            ru: "Отслеживайте статус записи в меню \"Мои записи\"",
            ua: "Відслідковуйте статус запису в меню \"Мої записи\""
        },
        popup_studies_text_two: {
            ru: "Когда администратор рассмотрит вашу запись, его статус изменится и вам перезвонят",
            ua: "Коли адміністратор розгляне ваш запис, його статусі зміниться та вам зателефонують"
        },
        popup_studies_send_button: {
            ru: "Отправить",
            ua: "Відправити"
        },
        welcome_name: {
            ru: "Валерий",
            ua: "Валерій"
        },
        welcome_login: {
            ru: "Войти",
            ua: "Увійти"
        },
        welcome_login_text: {
            ru: "Запись доступна только после входа в аккаунт на сайте, для этого нажмите кнопку “Войти”, если вы впервые на нашем сайте, то на странице входа вы сможете зарегистрировать новый аккаунт.",
            ua: "Запис доступний тільки після входу до акаунту на сайті, для цього натисніть на кнопку “Увійти”, якщо ви вперше на нашому сайті, то на сторінці входу ви зможете зареєструвати новий акаунт."
        },
        welcome_enrol: {
            ru: "Запись",
            ua: "Запис"
        },
        welcome_text_one: {
            ru: "Выберете дату и время",
            ua: "Виберіть дату та час"
        },
        welcome_text_two: {
            ru: "Доступные даты виделены синим, после нажатия отобразится время для записи",
            ua: "Доступні дати виділені синім, після натискання будуть відображені години для запису."
        },
        welcome_hours_available: {
            ru: "Доступное время для записи:",
            ua: "Доступні години для запису:"
        },
        footer_contacts: {
            ru: "Контакты",
            ua: "Контакти"
        }

    }
</script>
