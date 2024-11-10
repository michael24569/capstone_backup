    const PaiyakanBtn = document.getElementById('Paiyakan');
    const closeBtn = document.getElementById('closePanel');
    const panel = document.getElementById('imagePanel');
    const image = document.getElementById('responsiveImage');
    const slider = document.getElementById('slider');
    const prevBtn = document.getElementById('prevSlide');
    const nextBtn = document.getElementById('nextSlide');
    const James = document.getElementById('James');
    const Agustine = document.getElementById('Agustine');
    const Isidore = document.getElementById('Isidore')
    const Joseph =  document.getElementById('Joseph')
    const Jude = document.getElementById('Jude')
    const John =  document.getElementById('John')
    const Paul =  document.getElementById('Paul')
    const Peter = document.getElementById('Peter')
    const Matthew = document.getElementById('Matthew')
    const Dominic = document.getElementById('Dominic')
    const Rafael = document.getElementById('Rafael')
    const Mark = document.getElementById('Mark')
    const Luke = document.getElementById('Luke')
    const Michael = document.getElementById('Michael')

    const Apart1 = document.getElementById('Apart1')
    const Apart2 = document.getElementById('Apart2')
    const Apart3 = document.getElementById('Apart3')
    const Colum1 = document.getElementById('Colum1')
    const Colum2 = document.getElementById('Colum2')




    const IDRAFaclosebtn = document.getElementById('IDRAFaclosebtn')
    const IDpeterclosebtn = document.getElementById('IDpeterclosebtn')
    const IDpaulclosebtn = document.getElementById('IDpaulclosebtn')
    const IDjohnclosebtn = document.getElementById('IDjohnclosebtn')
    const IDjosephclosebtn = document.getElementById('IDjosephclosebtn')
    const IDjamesclosebtn = document.getElementById('IDjamesclosebtn')
    const IDmatthewclosebtn = document.getElementById('IDmatthewclosebtn')
    const IDagustineclosebtn = document.getElementById('IDagustineclosebtn')
    const IDjudeclosebtn = document.getElementById('IDjudeclosebtn')
    const IDisidoreclosebtn = document.getElementById('IDisidoreclosebtn')
    const IDdominicclosebtn = document.getElementById('IDdominicclosebtn')
    const IDmarkclosebtn = document.getElementById('IDmarkclosebtn')
    const IDlukeclosebtn = document.getElementById('IDlukeclosebtn')



    let currentIndex = 0;
    const totalSlides = slider.children.length;

    // Open panel with slide and apply blur effect
    PaiyakanBtn.addEventListener('click', () => {
        panel.classList.add('open');
        image.classList.add('blurred');
        James.classList.add('blurred');
        Agustine.classList.add('blurred');
        Isidore.classList.add('blurred');
        Joseph.classList.add('blurred');
        Jude.classList.add('blurred');
        John.classList.add('blurred');
        Paul.classList.add('blurred');
        Peter.classList.add('blurred');
        Matthew.classList.add('blurred');
        Dominic.classList.add('blurred');
        Rafael.classList.add('blurred');
        Mark.classList.add('blurred');
        Luke.classList.add('blurred');
        Michael.classList.add('blurred');


        Apart1.classList.add('blurred');
        Apart2.classList.add('blurred');
        Apart3.classList.add('blurred');
        Colum1.classList.add('blurred');
        Colum2.classList.add('blurred');
    });
    Rafael.addEventListener('click', () => {
        image.classList.add('blurred');
        James.classList.add('blurred');
        Agustine.classList.add('blurred');
        Isidore.classList.add('blurred');
        Joseph.classList.add('blurred');
        Jude.classList.add('blurred');
        John.classList.add('blurred');
        Paul.classList.add('blurred');
        Peter.classList.add('blurred');
        Matthew.classList.add('blurred');
        Dominic.classList.add('blurred');
        Rafael.classList.add('blurred');
        Mark.classList.add('blurred');
        Luke.classList.add('blurred');
        Apart1.classList.add('blurred');
        Apart2.classList.add('blurred');
        Apart3.classList.add('blurred');
        Colum1.classList.add('blurred');
        Colum2.classList.add('blurred');
        Michael.classList.add('blurred');

    });
    Peter.addEventListener('click', () => {
        image.classList.add('blurred');
        James.classList.add('blurred');
        Agustine.classList.add('blurred');
        Isidore.classList.add('blurred');
        Joseph.classList.add('blurred');
        Jude.classList.add('blurred');
        John.classList.add('blurred');
        Paul.classList.add('blurred');
        Peter.classList.add('blurred');
        Matthew.classList.add('blurred');
        Dominic.classList.add('blurred');
        Rafael.classList.add('blurred');
        Mark.classList.add('blurred');
        Luke.classList.add('blurred');
        Apart1.classList.add('blurred');
        Apart2.classList.add('blurred');
        Apart3.classList.add('blurred');
        Colum1.classList.add('blurred');
        Colum2.classList.add('blurred');
        Michael.classList.add('blurred');

    });
    Paul.addEventListener('click', () => {
        image.classList.add('blurred');
        James.classList.add('blurred');
        Agustine.classList.add('blurred');
        Isidore.classList.add('blurred');
        Joseph.classList.add('blurred');
        Jude.classList.add('blurred');
        John.classList.add('blurred');
        Paul.classList.add('blurred');
        Peter.classList.add('blurred');
        Matthew.classList.add('blurred');
        Dominic.classList.add('blurred');
        Rafael.classList.add('blurred');
        Mark.classList.add('blurred');
        Luke.classList.add('blurred');
        Apart1.classList.add('blurred');
        Apart2.classList.add('blurred');
        Apart3.classList.add('blurred');
        Colum1.classList.add('blurred');
        Colum2.classList.add('blurred');
        Michael.classList.add('blurred');

    });
    James.addEventListener('click', () => {
        image.classList.add('blurred');
        James.classList.add('blurred');
        Agustine.classList.add('blurred');
        Isidore.classList.add('blurred');
        Joseph.classList.add('blurred');
        Jude.classList.add('blurred');
        John.classList.add('blurred');
        Paul.classList.add('blurred');
        Peter.classList.add('blurred');
        Matthew.classList.add('blurred');
        Dominic.classList.add('blurred');
        Rafael.classList.add('blurred');
        Mark.classList.add('blurred');
        Luke.classList.add('blurred');
        Apart1.classList.add('blurred');
        Apart2.classList.add('blurred');
        Apart3.classList.add('blurred');
        Colum1.classList.add('blurred');
        Colum2.classList.add('blurred');
        Michael.classList.add('blurred');

    });
    Matthew.addEventListener('click', () => {
        image.classList.add('blurred');
        James.classList.add('blurred');
        Agustine.classList.add('blurred');
        Isidore.classList.add('blurred');
        Joseph.classList.add('blurred');
        Jude.classList.add('blurred');
        John.classList.add('blurred');
        Paul.classList.add('blurred');
        Peter.classList.add('blurred');
        Matthew.classList.add('blurred');
        Dominic.classList.add('blurred');
        Rafael.classList.add('blurred');
        Mark.classList.add('blurred');
        Luke.classList.add('blurred');
        Apart1.classList.add('blurred');
        Apart2.classList.add('blurred');
        Apart3.classList.add('blurred');
        Colum1.classList.add('blurred');
        Colum2.classList.add('blurred');
        Michael.classList.add('blurred');

    });
    Jude.addEventListener('click', () => {
        image.classList.add('blurred');
        James.classList.add('blurred');
        Agustine.classList.add('blurred');
        Isidore.classList.add('blurred');
        Joseph.classList.add('blurred');
        Jude.classList.add('blurred');
        John.classList.add('blurred');
        Paul.classList.add('blurred');
        Peter.classList.add('blurred');
        Matthew.classList.add('blurred');
        Dominic.classList.add('blurred');
        Rafael.classList.add('blurred');
        Mark.classList.add('blurred');
        Luke.classList.add('blurred');
        Apart1.classList.add('blurred');
        Apart2.classList.add('blurred');
        Apart3.classList.add('blurred');
        Colum1.classList.add('blurred');
        Colum2.classList.add('blurred');
        Michael.classList.add('blurred');

    });
    John.addEventListener('click', () => {
        image.classList.add('blurred');
        James.classList.add('blurred');
        Agustine.classList.add('blurred');
        Isidore.classList.add('blurred');
        Joseph.classList.add('blurred');
        Jude.classList.add('blurred');
        John.classList.add('blurred');
        Paul.classList.add('blurred');
        Peter.classList.add('blurred');
        Matthew.classList.add('blurred');
        Dominic.classList.add('blurred');
        Rafael.classList.add('blurred');
        Mark.classList.add('blurred');
        Luke.classList.add('blurred');
        Apart1.classList.add('blurred');
        Apart2.classList.add('blurred');
        Apart3.classList.add('blurred');
        Colum1.classList.add('blurred');
        Colum2.classList.add('blurred');
        Michael.classList.add('blurred');

    });
    Joseph.addEventListener('click', () => {
        image.classList.add('blurred');
        James.classList.add('blurred');
        Agustine.classList.add('blurred');
        Isidore.classList.add('blurred');
        Joseph.classList.add('blurred');
        Jude.classList.add('blurred');
        John.classList.add('blurred');
        Paul.classList.add('blurred');
        Peter.classList.add('blurred');
        Matthew.classList.add('blurred');
        Dominic.classList.add('blurred');
        Rafael.classList.add('blurred');
        Mark.classList.add('blurred');
        Luke.classList.add('blurred');
        Apart1.classList.add('blurred');
        Apart2.classList.add('blurred');
        Apart3.classList.add('blurred');
        Colum1.classList.add('blurred');
        Colum2.classList.add('blurred');
        Michael.classList.add('blurred');

    });
    Agustine.addEventListener('click', () => {
        image.classList.add('blurred');
        James.classList.add('blurred');
        Agustine.classList.add('blurred');
        Isidore.classList.add('blurred');
        Joseph.classList.add('blurred');
        Jude.classList.add('blurred');
        John.classList.add('blurred');
        Paul.classList.add('blurred');
        Peter.classList.add('blurred');
        Matthew.classList.add('blurred');
        Dominic.classList.add('blurred');
        Rafael.classList.add('blurred');
        Mark.classList.add('blurred');
        Luke.classList.add('blurred');
        Apart1.classList.add('blurred');
        Apart2.classList.add('blurred');
        Apart3.classList.add('blurred');
        Colum1.classList.add('blurred');
        Colum2.classList.add('blurred');
        Michael.classList.add('blurred');

    });

    Isidore.addEventListener('click', () => {
        image.classList.add('blurred');
        James.classList.add('blurred');
        Agustine.classList.add('blurred');
        Isidore.classList.add('blurred');
        Joseph.classList.add('blurred');
        Jude.classList.add('blurred');
        John.classList.add('blurred');
        Paul.classList.add('blurred');
        Peter.classList.add('blurred');
        Matthew.classList.add('blurred');
        Dominic.classList.add('blurred');
        Rafael.classList.add('blurred');
        Mark.classList.add('blurred');
        Luke.classList.add('blurred');
        Apart1.classList.add('blurred');
        Apart2.classList.add('blurred');
        Apart3.classList.add('blurred');
        Colum1.classList.add('blurred');
        Colum2.classList.add('blurred');
        Michael.classList.add('blurred');

    });

    Dominic.addEventListener('click', () => {
        image.classList.add('blurred');
        James.classList.add('blurred');
        Agustine.classList.add('blurred');
        Isidore.classList.add('blurred');
        Joseph.classList.add('blurred');
        Jude.classList.add('blurred');
        John.classList.add('blurred');
        Paul.classList.add('blurred');
        Peter.classList.add('blurred');
        Matthew.classList.add('blurred');
        Dominic.classList.add('blurred');
        Rafael.classList.add('blurred');
        Mark.classList.add('blurred');
        Luke.classList.add('blurred');
        Apart1.classList.add('blurred');
        Apart2.classList.add('blurred');
        Apart3.classList.add('blurred');
        Colum1.classList.add('blurred');
        Colum2.classList.add('blurred');
        Michael.classList.add('blurred');

    });
    Mark.addEventListener('click', () => {
        image.classList.add('blurred');
        James.classList.add('blurred');
        Agustine.classList.add('blurred');
        Isidore.classList.add('blurred');
        Joseph.classList.add('blurred');
        Jude.classList.add('blurred');
        John.classList.add('blurred');
        Paul.classList.add('blurred');
        Peter.classList.add('blurred');
        Matthew.classList.add('blurred');
        Dominic.classList.add('blurred');
        Rafael.classList.add('blurred');
        Mark.classList.add('blurred');
        Luke.classList.add('blurred');
        Apart1.classList.add('blurred');
        Apart2.classList.add('blurred');
        Apart3.classList.add('blurred');
        Colum1.classList.add('blurred');
        Colum2.classList.add('blurred');
        Michael.classList.add('blurred');

    });
    Luke.addEventListener('click', () => {
        image.classList.add('blurred');
        James.classList.add('blurred');
        Agustine.classList.add('blurred');
        Isidore.classList.add('blurred');
        Joseph.classList.add('blurred');
        Jude.classList.add('blurred');
        John.classList.add('blurred');
        Paul.classList.add('blurred');
        Peter.classList.add('blurred');
        Matthew.classList.add('blurred');
        Dominic.classList.add('blurred');
        Rafael.classList.add('blurred');
        Mark.classList.add('blurred');
        Luke.classList.add('blurred');
        Apart1.classList.add('blurred');
        Apart2.classList.add('blurred');
        Apart3.classList.add('blurred');
        Colum1.classList.add('blurred');
        Colum2.classList.add('blurred');
        Michael.classList.add('blurred');

    });
    // Close panel and remove blur effect
    closeBtn.addEventListener('click', () => {
        panel.classList.remove('open');
        image.classList.remove('blurred');
        James.classList.remove('blurred');
        Agustine.classList.remove('blurred');
        Isidore.classList.remove('blurred');
        Joseph.classList.remove('blurred');
        Jude.classList.remove('blurred');
        John.classList.remove('blurred');
        Paul.classList.remove('blurred');
        Peter.classList.remove('blurred');
        Matthew.classList.remove('blurred');
        Dominic.classList.remove('blurred');
        Rafael.classList.remove('blurred');
        Mark.classList.remove('blurred');
        Luke.classList.remove('blurred');
        Apart1.classList.remove('blurred');
        Apart2.classList.remove('blurred');
        Apart3.classList.remove('blurred');
        Colum1.classList.remove('blurred');
        Colum2.classList.remove('blurred');
        Michael.classList.remove('blurred');



    });
    IDlukeclosebtn.addEventListener('click', () => {
        image.classList.remove('blurred');
        James.classList.remove('blurred');
        Agustine.classList.remove('blurred');
        Isidore.classList.remove('blurred');
        Joseph.classList.remove('blurred');
        Jude.classList.remove('blurred');
        John.classList.remove('blurred');
        Paul.classList.remove('blurred');
        Peter.classList.remove('blurred');
        Matthew.classList.remove('blurred');
        Dominic.classList.remove('blurred');
        Rafael.classList.remove('blurred');
        Mark.classList.remove('blurred');
        Luke.classList.remove('blurred');
        Apart1.classList.remove('blurred');
        Apart2.classList.remove('blurred');
        Apart3.classList.remove('blurred');
        Colum1.classList.remove('blurred');
        Colum2.classList.remove('blurred');
        Michael.classList.remove('blurred');

    });
    IDmarkclosebtn.addEventListener('click', () => {
        image.classList.remove('blurred');
        James.classList.remove('blurred');
        Agustine.classList.remove('blurred');
        Isidore.classList.remove('blurred');
        Joseph.classList.remove('blurred');
        Jude.classList.remove('blurred');
        John.classList.remove('blurred');
        Paul.classList.remove('blurred');
        Peter.classList.remove('blurred');
        Matthew.classList.remove('blurred');
        Dominic.classList.remove('blurred');
        Rafael.classList.remove('blurred');
        Mark.classList.remove('blurred');
        Luke.classList.remove('blurred');
        Apart1.classList.remove('blurred');
        Apart2.classList.remove('blurred');
        Apart3.classList.remove('blurred');
        Colum1.classList.remove('blurred');
        Colum2.classList.remove('blurred');
        Michael.classList.remove('blurred');


    });
    IDdominicclosebtn.addEventListener('click', () => {
        image.classList.remove('blurred');
        James.classList.remove('blurred');
        Agustine.classList.remove('blurred');
        Isidore.classList.remove('blurred');
        Joseph.classList.remove('blurred');
        Jude.classList.remove('blurred');
        John.classList.remove('blurred');
        Paul.classList.remove('blurred');
        Peter.classList.remove('blurred');
        Matthew.classList.remove('blurred');
        Dominic.classList.remove('blurred');
        Rafael.classList.remove('blurred');
        Mark.classList.remove('blurred');
        Luke.classList.remove('blurred');
        Apart1.classList.remove('blurred');
        Apart2.classList.remove('blurred');
        Apart3.classList.remove('blurred');
        Colum1.classList.remove('blurred');
        Colum2.classList.remove('blurred');
        Michael.classList.remove('blurred');

    });
    IDisidoreclosebtn.addEventListener('click', () => {
        image.classList.remove('blurred');
        James.classList.remove('blurred');
        Agustine.classList.remove('blurred');
        Isidore.classList.remove('blurred');
        Joseph.classList.remove('blurred');
        Jude.classList.remove('blurred');
        John.classList.remove('blurred');
        Paul.classList.remove('blurred');
        Peter.classList.remove('blurred');
        Matthew.classList.remove('blurred');
        Dominic.classList.remove('blurred');
        Rafael.classList.remove('blurred');
        Mark.classList.remove('blurred');
        Luke.classList.remove('blurred');
        Apart1.classList.remove('blurred');
        Apart2.classList.remove('blurred');
        Apart3.classList.remove('blurred');
        Colum1.classList.remove('blurred');
        Colum2.classList.remove('blurred');
        Michael.classList.remove('blurred');

    });
    IDagustineclosebtn.addEventListener('click', () => {
        image.classList.remove('blurred');
        James.classList.remove('blurred');
        Agustine.classList.remove('blurred');
        Isidore.classList.remove('blurred');
        Joseph.classList.remove('blurred');
        Jude.classList.remove('blurred');
        John.classList.remove('blurred');
        Paul.classList.remove('blurred');
        Peter.classList.remove('blurred');
        Matthew.classList.remove('blurred');
        Dominic.classList.remove('blurred');
        Rafael.classList.remove('blurred');
        Mark.classList.remove('blurred');
        Luke.classList.remove('blurred');
        Apart1.classList.remove('blurred');
        Apart2.classList.remove('blurred');
        Apart3.classList.remove('blurred');
        Colum1.classList.remove('blurred');
        Colum2.classList.remove('blurred');
        Michael.classList.remove('blurred');


    });
    IDjosephclosebtn.addEventListener('click', () => {
        image.classList.remove('blurred');
        James.classList.remove('blurred');
        Agustine.classList.remove('blurred');
        Isidore.classList.remove('blurred');
        Joseph.classList.remove('blurred');
        Jude.classList.remove('blurred');
        John.classList.remove('blurred');
        Paul.classList.remove('blurred');
        Peter.classList.remove('blurred');
        Matthew.classList.remove('blurred');
        Dominic.classList.remove('blurred');
        Rafael.classList.remove('blurred');
        Mark.classList.remove('blurred');
        Luke.classList.remove('blurred');
        Apart1.classList.remove('blurred');
        Apart2.classList.remove('blurred');
        Apart3.classList.remove('blurred');
        Colum1.classList.remove('blurred');
        Colum2.classList.remove('blurred');
        Michael.classList.remove('blurred');

    });
    IDjohnclosebtn.addEventListener('click', () => {
        image.classList.remove('blurred');
        James.classList.remove('blurred');
        Agustine.classList.remove('blurred');
        Isidore.classList.remove('blurred');
        Joseph.classList.remove('blurred');
        Jude.classList.remove('blurred');
        John.classList.remove('blurred');
        Paul.classList.remove('blurred');
        Peter.classList.remove('blurred');
        Matthew.classList.remove('blurred');
        Dominic.classList.remove('blurred');
        Rafael.classList.remove('blurred');
        Mark.classList.remove('blurred');
        Luke.classList.remove('blurred');
        Apart1.classList.remove('blurred');
        Apart2.classList.remove('blurred');
        Apart3.classList.remove('blurred');
        Colum1.classList.remove('blurred');
        Colum2.classList.remove('blurred');
        Michael.classList.remove('blurred');

    });
    IDjudeclosebtn.addEventListener('click', () => {
        image.classList.remove('blurred');
        James.classList.remove('blurred');
        Agustine.classList.remove('blurred');
        Isidore.classList.remove('blurred');
        Joseph.classList.remove('blurred');
        Jude.classList.remove('blurred');
        John.classList.remove('blurred');
        Paul.classList.remove('blurred');
        Peter.classList.remove('blurred');
        Matthew.classList.remove('blurred');
        Dominic.classList.remove('blurred');
        Rafael.classList.remove('blurred');
        Mark.classList.remove('blurred');
        Luke.classList.remove('blurred');
        Apart1.classList.remove('blurred');
        Apart2.classList.remove('blurred');
        Apart3.classList.remove('blurred');
        Colum1.classList.remove('blurred');
        Colum2.classList.remove('blurred');
        Michael.classList.remove('blurred');

    });
    IDmatthewclosebtn.addEventListener('click', () => {
        image.classList.remove('blurred');
        James.classList.remove('blurred');
        Agustine.classList.remove('blurred');
        Isidore.classList.remove('blurred');
        Joseph.classList.remove('blurred');
        Jude.classList.remove('blurred');
        John.classList.remove('blurred');
        Paul.classList.remove('blurred');
        Peter.classList.remove('blurred');
        Matthew.classList.remove('blurred');
        Dominic.classList.remove('blurred');
        Rafael.classList.remove('blurred');
        Mark.classList.remove('blurred');
        Luke.classList.remove('blurred');
        Apart1.classList.remove('blurred');
        Apart2.classList.remove('blurred');
        Apart3.classList.remove('blurred');
        Colum1.classList.remove('blurred');
        Colum2.classList.remove('blurred');
        Michael.classList.remove('blurred');

    });
    IDjamesclosebtn.addEventListener('click', () => {
        image.classList.remove('blurred');
        James.classList.remove('blurred');
        Agustine.classList.remove('blurred');
        Isidore.classList.remove('blurred');
        Joseph.classList.remove('blurred');
        Jude.classList.remove('blurred');
        John.classList.remove('blurred');
        Paul.classList.remove('blurred');
        Peter.classList.remove('blurred');
        Matthew.classList.remove('blurred');
        Dominic.classList.remove('blurred');
        Rafael.classList.remove('blurred');
        Mark.classList.remove('blurred');
        Luke.classList.remove('blurred');
        Apart1.classList.remove('blurred');
        Apart2.classList.remove('blurred');
        Apart3.classList.remove('blurred');
        Colum1.classList.remove('blurred');
        Colum2.classList.remove('blurred');
        Michael.classList.remove('blurred');

    });
    IDpaulclosebtn.addEventListener('click', () => {
        image.classList.remove('blurred');
        James.classList.remove('blurred');
        Agustine.classList.remove('blurred');
        Isidore.classList.remove('blurred');
        Joseph.classList.remove('blurred');
        Jude.classList.remove('blurred');
        John.classList.remove('blurred');
        Paul.classList.remove('blurred');
        Peter.classList.remove('blurred');
        Matthew.classList.remove('blurred');
        Dominic.classList.remove('blurred');
        Rafael.classList.remove('blurred');
        Mark.classList.remove('blurred');
        Luke.classList.remove('blurred');
        Apart1.classList.remove('blurred');
        Apart2.classList.remove('blurred');
        Apart3.classList.remove('blurred');
        Colum1.classList.remove('blurred');
        Colum2.classList.remove('blurred');
        Michael.classList.remove('blurred');

    });
    IDpeterclosebtn.addEventListener('click', () => {
        image.classList.remove('blurred');
        James.classList.remove('blurred');
        Agustine.classList.remove('blurred');
        Isidore.classList.remove('blurred');
        Joseph.classList.remove('blurred');
        Jude.classList.remove('blurred');
        John.classList.remove('blurred');
        Paul.classList.remove('blurred');
        Peter.classList.remove('blurred');
        Matthew.classList.remove('blurred');
        Dominic.classList.remove('blurred');
        Rafael.classList.remove('blurred');
        Mark.classList.remove('blurred');
        Luke.classList.remove('blurred');
        Apart1.classList.remove('blurred');
        Apart2.classList.remove('blurred');
        Apart3.classList.remove('blurred');
        Colum1.classList.remove('blurred');
        Colum2.classList.remove('blurred');
        Michael.classList.remove('blurred');

    });
    IDRAFaclosebtn.addEventListener('click', () => {
        image.classList.remove('blurred');
        James.classList.remove('blurred');
        Agustine.classList.remove('blurred');
        Isidore.classList.remove('blurred');
        Joseph.classList.remove('blurred');
        Jude.classList.remove('blurred');
        John.classList.remove('blurred');
        Paul.classList.remove('blurred');
        Peter.classList.remove('blurred');
        Matthew.classList.remove('blurred');
        Dominic.classList.remove('blurred');
        Rafael.classList.remove('blurred');
        Mark.classList.remove('blurred');
        Luke.classList.remove('blurred');
        Apart1.classList.remove('blurred');
        Apart2.classList.remove('blurred');
        Apart3.classList.remove('blurred');
        Colum1.classList.remove('blurred');
        Colum2.classList.remove('blurred');
        Michael.classList.remove('blurred');
    });

    // Move to the next slide
    nextBtn.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % totalSlides;
        updateSliderPosition();
    });

    // Move to the previous slide
    prevBtn.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        updateSliderPosition();
    });

    // Update the slider's position
    function updateSliderPosition() {
        slider.style.transform = `translateX(-${currentIndex * 100}%)`;
    }
