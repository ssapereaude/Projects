/* 
 * Name: Filip Melka & Temur Rustamov
 * Date: April 2024
 */

package screens.tabs;

import javax.swing.JOptionPane;
import javax.swing.JPanel;
import components.Button;
import components.PasswordInput;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import utils.Colors;
import utils.DB;
import utils.Fonts;
import utils.User;
import utils.exceptions.EmptyInputException;
import utils.exceptions.PasswordHashingException;
import utils.exceptions.PasswordUpdateException;
import utils.exceptions.PasswordsNotMatchingException;
import utils.exceptions.WrongPasswordException;

public class PasswordTab extends Tab implements ActionListener {

    private final int MARGIN_TOP = PADDING_Y + TITLE_HEIGHT + 40;
    final int INPUT_HEIGHT = 42;
    final int INPUT_WIDTH = 300;
    final int GAP = 20;

    final String[] LABELS = {
            "Current Password", "New Password", "Confirm Password"
    };

    PasswordInput[] passwordInputs;
    JPanel btnsPanel;
    Button clearBtn;
    Button submitBtn;

    private void clearInputs() {
        for (PasswordInput input : passwordInputs) {
            input.clear();
            input.setBorderColor(Colors.GRAY_LIGHT);
        }
    }

    private void checkInputsNotEmpty() throws EmptyInputException {
        boolean isEmpty = false;
        for (PasswordInput input : passwordInputs) {
            if (input.getPassword().length() == 0) {
                isEmpty = true;
                input.setBorderColor(Colors.RED);
                input.clear();
            }
        }

        if (isEmpty) {
            throw new EmptyInputException("Empty input");
        }
    }

    private void checkConfirmPassword() throws PasswordsNotMatchingException {
        if (passwordInputs[1].getPassword().compareTo(passwordInputs[2].getPassword()) != 0) {
            passwordInputs[1].setBorderColor(Colors.RED);
            passwordInputs[2].setBorderColor(Colors.RED);
            passwordInputs[1].clear();
            passwordInputs[2].clear();
            throw new PasswordsNotMatchingException("Passwords do not match");
        }
    }

    public void actionPerformed(ActionEvent ev) {
        if (ev.getSource() == clearBtn) {
            clearInputs();
        } else if (ev.getSource() == submitBtn) {

            for (PasswordInput input : passwordInputs) {
                input.setBorderColor(Colors.GRAY_LIGHT);
            }

            try {
                submitBtn.setIsEnabled(false);
                // check that inputs are not empty
                checkInputsNotEmpty();

                // check that new password and confirm password are matching
                checkConfirmPassword();

                /* Update Password */
                Connection connection = null;
                PreparedStatement pstat = null;

                try {
                    /* Check current password */
                    URL obj = new URL("http://localhost:3000/api/login?username=" + User.getUsername() + "&password="
                            + passwordInputs[0].getPassword());
                    HttpURLConnection con = (HttpURLConnection) obj.openConnection();
                    con.setRequestMethod("GET");
                    con.setRequestProperty("User-Agent", "Mozilla/5.0");
                    int responseCode = con.getResponseCode();

                    if (responseCode == HttpURLConnection.HTTP_OK) {
                        BufferedReader in = new BufferedReader(new InputStreamReader(con.getInputStream()));
                        String inputLine;
                        StringBuffer response = new StringBuffer();

                        while ((inputLine = in.readLine()) != null) {
                            response.append(inputLine);
                        }
                        in.close();

                        if (response.toString().compareTo("null") == 0) {
                            throw new WrongPasswordException("Wrong Password");
                        } else {
                            /* correct current password */
                            /* get hashed password */
                            String newPassword = passwordInputs[1].getPassword();
                            obj = new URL("http://localhost:3000/api/hash-password?password=" + newPassword);
                            con = (HttpURLConnection) obj.openConnection();
                            con.setRequestMethod("GET");
                            con.setRequestProperty("User-Agent", "Mozilla/5.0");
                            responseCode = con.getResponseCode();

                            if (responseCode == HttpURLConnection.HTTP_OK) {
                                in = new BufferedReader(new InputStreamReader(con.getInputStream()));
                                response = new StringBuffer();

                                while ((inputLine = in.readLine()) != null) {
                                    response.append(inputLine);
                                }
                                in.close();

                                String hashedPassword = response.toString().replaceAll("\"", "");

                                // update DB
                                try {
                                    connection = DriverManager.getConnection(DB.URL, DB.USER, DB.PASSWORD);
                                    pstat = connection
                                            .prepareStatement("UPDATE users SET password=? WHERE username=?");
                                    pstat.setString(1, hashedPassword);
                                    pstat.setString(2, User.getUsername());

                                    System.out.println("hashed:" + hashedPassword);

                                    int i = pstat.executeUpdate();

                                    if (i == 0) {
                                        // updating password failed
                                        throw new PasswordUpdateException("Password update failed");
                                    }

                                    JOptionPane.showMessageDialog(null, "Password has been changed");
                                } catch (Exception e) {
                                    JOptionPane.showMessageDialog(null, e.getMessage());
                                } finally {
                                    pstat.close();
                                    connection.close();
                                }
                            } else {
                                // hashing password failed
                                throw new PasswordHashingException("Password hashing failed");
                            }
                        }
                    } else {
                        throw new WrongPasswordException("Wrong Password");
                    }
                } catch (Exception e) {
                    e.printStackTrace();
                    JOptionPane.showMessageDialog(null, e.getMessage());
                } finally {
                    clearInputs();
                }

            } catch (Exception e) {
                e.printStackTrace();
            } finally {
                submitBtn.setIsEnabled(true);
            }

        }

    }

    public PasswordTab() {
        super("Change Password");

        passwordInputs = new PasswordInput[3];

        for (int i = 0; i < 3; i++) {
            passwordInputs[i] = new PasswordInput(LABELS[i], PADDING_X, MARGIN_TOP + i * (INPUT_HEIGHT * 2 + GAP),
                    INPUT_WIDTH, INPUT_HEIGHT);

            this.add(passwordInputs[i]);
        }

        btnsPanel = new JPanel();
        btnsPanel.setBounds(PADDING_X, MARGIN_TOP + 3 * (INPUT_HEIGHT * 2 + GAP + 20) + GAP, INPUT_WIDTH, INPUT_HEIGHT);
        btnsPanel.setLayout(null);
        btnsPanel.setBackground(Colors.BG);

        clearBtn = new Button("Clear");
        clearBtn.setBounds(0, 0, INPUT_WIDTH / 2 - 10, INPUT_HEIGHT);
        clearBtn.setBackground(Colors.BG);
        clearBtn.setFont(Fonts.DEFAULT);
        clearBtn.setForeground(Colors.TEXT);
        clearBtn.addActionListener(this);
        btnsPanel.add(clearBtn);

        submitBtn = new Button("Submit");
        submitBtn.setBounds(INPUT_WIDTH / 2 + 20, 0, INPUT_WIDTH / 2 - 10, INPUT_HEIGHT);
        submitBtn.setBackground(Colors.PRIMARY);
        submitBtn.setFont(Fonts.DEFAULT);
        submitBtn.setForeground(Colors.BG);
        submitBtn.addActionListener(this);
        btnsPanel.add(submitBtn);

        this.add(btnsPanel);
    }

}
