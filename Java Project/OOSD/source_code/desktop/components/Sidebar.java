/* 
 * Name: Filip Melka & Temur Rustamov
 * Date: April 2024
 */

package components;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import javax.swing.JPanel;
import screens.MainScreen;
import screens.MainScreen.Tabs;
import utils.Colors;
import utils.Window;

public class Sidebar extends JPanel implements ActionListener {

    final int WIDTH = 340;
    final int PADDING = 40;
    final int BUTTON_HEIGHT = 46;
    final String[] BUTTON_LABELS = {
            "View Payments",
            "View Results",
            "Change Password",
            "Manage Account",
    };
    final String[] ICONS = {
            "payments",
            "results",
            "password",
            "account",
    };
    MainScreen mainScreen;
    Avatar avatar;
    LinkButton link;
    OptionButton[] btns;
    int selectedOptionIndex = 0;

    public void actionPerformed(ActionEvent ev) {
        int btnId = Integer.valueOf(ev.getSource().toString());

        btns[selectedOptionIndex].setIsEnabled(true);
        btns[selectedOptionIndex].setBackground(Colors.BG_LIGHT);

        selectedOptionIndex = btnId;
        btns[selectedOptionIndex].setIsEnabled(false);
        btns[selectedOptionIndex].setBackground(Colors.BG);

        Tabs newTab = null;

        switch (btnId) {
            case 0:
                newTab = Tabs.PAYMENTS;
                break;
            case 1:
                newTab = Tabs.RESULTS;
                break;
            case 2:
                newTab = Tabs.PASSWORD;
                break;
            case 3:
                newTab = Tabs.ACCOUNT;
                break;
        }

        if (newTab != null) {
            mainScreen.changeTab(newTab);
        }

    }

    public Sidebar(MainScreen mainScreen) {
        this.mainScreen = mainScreen;

        this.setBackground(Colors.BG_LIGHT);
        this.setBounds(0, 0, WIDTH, Window.WINDOW_HEIGHT);
        this.setLayout(null);

        /* avatar */
        avatar = new Avatar();
        avatar.setBounds(PADDING, PADDING, WIDTH - 2 * PADDING, 55);
        this.add(avatar);

        /* link button */
        link = new LinkButton("Casino 🔗");
        link.setBounds(40, Window.WINDOW_HEIGHT - PADDING * 2 - BUTTON_HEIGHT, WIDTH - 2 * PADDING, BUTTON_HEIGHT);
        this.add(link);

        /* buttons */
        btns = new OptionButton[4];
        for (int i = 0; i < btns.length; i++) {
            btns[i] = new OptionButton(BUTTON_LABELS[i], ICONS[i], WIDTH, (BUTTON_HEIGHT + 15),
                    PADDING, i);
            btns[i].setBounds(0, 150 + i * (BUTTON_HEIGHT + 15), WIDTH, BUTTON_HEIGHT + 15);
            btns[i].addActionListener(this);
            this.add(btns[i]);
        }
        btns[0].setBackground(Colors.BG);
        btns[0].setIsEnabled(false);
    }

}
