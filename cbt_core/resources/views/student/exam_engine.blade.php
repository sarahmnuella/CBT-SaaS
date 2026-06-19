<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBT Engine - {{ $exam->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-primary: #080c14;
            --bg-secondary: #0f172a;
            --bg-card: #1e293b;
            --border-color: rgba(255, 255, 255, 0.08);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --accent-color: #3b82f6;
            --success-color: #10b981;
            --danger-color: #ef4444;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            user-select: none; /* Disable text copy */
        }

        /* Header Engine */
        .header {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .header h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .timer-box {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: var(--danger-color);
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-family: monospace;
            font-size: 1.25rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Layout Grid */
        .main-container {
            display: grid;
            grid-template-columns: 1fr 300px;
            flex: 1;
            height: calc(100vh - 70px);
        }

        /* Left Content Panel: Question & Choices */
        .exam-area {
            padding: 2.5rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: rgba(15, 23, 42, 0.3);
        }

        .question-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .question-text {
            font-size: 1.15rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .question-image {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: block;
        }

        .options-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .option-item {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .option-item:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255,255,255,0.25);
        }

        .option-item.selected {
            background: rgba(59, 130, 246, 0.1);
            border-color: var(--accent-color);
        }

        .option-item input {
            display: none;
        }

        .option-label {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
            margin-right: 1rem;
            flex-shrink: 0;
            color: var(--text-secondary);
        }

        .option-item.selected .option-label {
            background: var(--accent-color);
            border-color: var(--accent-color);
            color: white;
        }

        .option-text {
            font-size: 1rem;
            line-height: 1.4;
        }

        /* Navigation Buttons */
        .nav-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
        }

        .btn-primary { background: var(--accent-color); color: white; }
        .btn-secondary { background: rgba(255,255,255,0.05); border: 1px solid var(--border-color); color: white; }
        .btn-success { background: var(--success-color); color: white; }

        /* Right Panel: Numbers Grid */
        .numbers-panel {
            background: var(--bg-secondary);
            border-left: 1px solid var(--border-color);
            padding: 1.5rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .numbers-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            margin-bottom: 1rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .numbers-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 0.5rem;
        }

        .num-btn {
            aspect-ratio: 1;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-secondary);
            font-weight: bold;
            font-size: 0.95rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .num-btn:hover {
            border-color: var(--accent-color);
            color: var(--accent-color);
        }

        .num-btn.answered {
            background: rgba(16, 185, 129, 0.15);
            border-color: var(--success-color);
            color: var(--success-color);
        }

        .num-btn.current {
            background: var(--accent-color);
            color: white;
            border-color: var(--accent-color);
        }
    </style>
</head>
<body oncontextmenu="return false;"> <!-- Disable Right Click -->

    <div class="header">
        <div>
            <h1>{{ $exam->name }}</h1>
            <p style="font-size:0.8rem; color:var(--text-secondary)">Mata Pelajaran: {{ $exam->subject->name }}</p>
        </div>
        <div class="timer-box">
            <i class="fa-solid fa-clock"></i>
            <span id="countdown">--:--:--</span>
        </div>
    </div>

    <div class="main-container">
        <!-- Question Panel -->
        <div class="exam-area">
            @foreach($orderedQuestions as $idx => $q)
                <div class="question-container" id="q-container-{{ $idx }}" style="display: {{ $idx === 0 ? 'block' : 'none' }};">
                    <div class="question-card">
                        <div style="font-size:0.85rem; color:var(--text-secondary); margin-bottom:0.75rem;">SOAL NOMOR {{ $idx + 1 }}</div>
                        <div class="question-text">
                            {!! nl2br(e($q->question)) !!}
                        </div>
                        @if($q->image)
                            <img class="question-image" src="{{ asset('storage/' . $q->image) }}" alt="Gambar Soal">
                        @endif

                        <div class="options-list">
                            @foreach(['A', 'B', 'C', 'D', 'E'] as $opt)
                                @php
                                    $optionField = 'option_' . strtolower($opt);
                                    $optionText = $q->$optionField;
                                    $savedAnswer = $result->answers[$q->id] ?? null;
                                @endphp
                                @if($optionText)
                                    <label class="option-item {{ $savedAnswer === $opt ? 'selected' : '' }}" id="label-{{ $q->id }}-{{ $opt }}">
                                        <input type="radio" name="answer_{{ $q->id }}" value="{{ $opt }}" {{ $savedAnswer === $opt ? 'checked' : '' }} onchange="saveAnswer({{ $q->id }}, '{{ $opt }}', {{ $idx }})">
                                        <span class="option-label">{{ $opt }}</span>
                                        <span class="option-text">{{ $optionText }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Action buttons -->
            <div class="nav-footer">
                <button id="btn-prev" class="btn btn-secondary" onclick="prevQuestion()" disabled>
                    <i class="fa-solid fa-chevron-left"></i> Sebelumnya
                </button>
                <button id="btn-next" class="btn btn-primary" onclick="nextQuestion()">
                    Berikutnya <i class="fa-solid fa-chevron-right"></i>
                </button>
                <button id="btn-submit" class="btn btn-success" style="display:none;" onclick="openSubmitConfirm()">
                    Selesaikan Ujian <i class="fa-solid fa-circle-check"></i>
                </button>
            </div>
        </div>

        <!-- Numbers Grid Panel -->
        <div class="numbers-panel">
            <div>
                <div class="numbers-title">Navigasi Soal</div>
                <div class="numbers-grid">
                    @foreach($orderedQuestions as $idx => $q)
                        @php
                            $savedAnswer = $result->answers[$q->id] ?? null;
                        @endphp
                        <button class="num-btn {{ $idx === 0 ? 'current' : '' }} {{ $savedAnswer ? 'answered' : '' }}" id="num-btn-{{ $idx }}" onclick="goToQuestion({{ $idx }})">
                            {{ $idx + 1 }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div style="border-top:1px solid var(--border-color); padding-top:1rem; margin-top:1.5rem;">
                <p style="font-size:0.8rem; color:var(--text-secondary); line-height:1.4;">
                    <i class="fa-solid fa-shield-halved"></i> Anti-Cheat Aktif: Jangan keluar tab/aplikasi browser ini.
                </p>
            </div>
        </div>
    </div>

    <!-- Submit Hidden Form -->
    <form id="submitForm" action="{{ route('student.exam.submit', ['slug' => session('tenant_slug'), 'id' => $exam->id]) }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="cheating" id="cheatField" value="false">
    </form>

    <script>
        let currentIdx = 0;
        const totalQuestions = {{ count($orderedQuestions) }};
        let timeRemaining = {{ $timeRemaining }};
        let cheatWarnings = 0;

        // Timer implementation
        const timerElement = document.getElementById('countdown');
        const countdownInterval = setInterval(() => {
            if (timeRemaining <= 0) {
                clearInterval(countdownInterval);
                autoSubmitExam();
            } else {
                timeRemaining--;
                let hours = Math.floor(timeRemaining / 3600);
                let minutes = Math.floor((timeRemaining % 3600) / 60);
                let seconds = timeRemaining % 60;
                
                hours = hours < 10 ? '0' + hours : hours;
                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;
                
                timerElement.innerText = `${hours}:${minutes}:${seconds}`;
            }
        }, 1000);

        function goToQuestion(idx) {
            document.getElementById(`q-container-${currentIdx}`).style.display = 'none';
            document.getElementById(`num-btn-${currentIdx}`).classList.remove('current');
            
            currentIdx = idx;
            
            document.getElementById(`q-container-${currentIdx}`).style.display = 'block';
            document.getElementById(`num-btn-${currentIdx}`).classList.add('current');
            
            // Toggle footer buttons
            document.getElementById('btn-prev').disabled = currentIdx === 0;
            if (currentIdx === totalQuestions - 1) {
                document.getElementById('btn-next').style.display = 'none';
                document.getElementById('btn-submit').style.display = 'inline-flex';
            } else {
                document.getElementById('btn-next').style.display = 'inline-flex';
                document.getElementById('btn-submit').style.display = 'none';
            }
        }

        function nextQuestion() {
            if (currentIdx < totalQuestions - 1) {
                goToQuestion(currentIdx + 1);
            }
        }

        function prevQuestion() {
            if (currentIdx > 0) {
                goToQuestion(currentIdx - 1);
            }
        }

        function saveAnswer(questionId, choice, index) {
            // Highlight selected option visually
            const labelGroup = document.querySelectorAll(`[id^="label-${questionId}-"]`);
            labelGroup.forEach(lbl => lbl.classList.remove('selected'));
            document.getElementById(`label-${questionId}-${choice}`).classList.add('selected');
            
            // Mark number panel
            document.getElementById(`num-btn-${index}`).classList.add('answered');

            // Send AJAX to server to auto-save answer
            fetch(`/s/{{ session('tenant_slug') }}/exam/{{ $exam->id }}/save`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    question_id: questionId,
                    answer: choice
                })
            });
        }

        function openSubmitConfirm() {
            if (confirm("Apakah Anda yakin ingin menyelesaikan ujian ini? Lembar jawaban akan dikirim secara permanen.")) {
                document.getElementById('submitForm').submit();
            }
        }

        function autoSubmitExam() {
            document.getElementById('submitForm').submit();
        }

        // =========================================================================
        // ANTI CHEATING SYSTEM: Detect Tab Change or Screen Minimizing
        // =========================================================================
        window.addEventListener('blur', function() {
            cheatWarnings++;
            alert("PERINGATAN KECURANGAN: Jangan tinggalkan halaman ujian! Meninggalkan ujian berakibat pembatalan otomatis.");
            
            if (cheatWarnings >= 1) {
                document.getElementById('cheatField').value = 'true';
                document.getElementById('submitForm').submit();
            }
        });

        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'hidden') {
                document.getElementById('cheatField').value = 'true';
                document.getElementById('submitForm').submit();
            }
        });
    </script>
</body>
</html>
